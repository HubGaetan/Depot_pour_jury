<?php

namespace App\Command;

use App\Entity\Menus;
use App\Models\StatusUser;
use App\Entity\RelMenusUser;
use App\Repository\UserRepository;
use App\Repository\MenusRepository;
use App\Services\Gestion_date_service;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RelMenusUserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// cette classe permet de générer automatiquement le menu de la semaine S+2 et d'inscrire automatiquement les eleves 
// a ce menu en fonction de leurs statuts.
class CreateWeeklyMenuCommand extends Command
{
    private $entityManager;
    private $menusRepository;
    private $userRepository;
    private $relMenusUserRepository;
    private $gestionDate;
    protected static $defaultName = 'app:create-weekly-menu';

    public function __construct(EntityManagerInterface $entityManager, RelMenusUserRepository $relMenusUserRepository, Gestion_date_service $gestionDate, UserRepository $userRepository, MenusRepository $menusRepository)
    {
        $this->entityManager = $entityManager;
        $this->gestionDate = $gestionDate;
        $this->menusRepository = $menusRepository;
        $this->userRepository = $userRepository;
        $this->relMenusUserRepository = $relMenusUserRepository;

        parent::__construct();
    }

    // on configure la commande 
    protected function configure()
    {
        $this
            ->setDescription('Create the weekly menu for the following week.')
            ->setHelp('This command allows you to create the menu for the following week.')
            ->setName(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // on recupere le numero de la semaine actuelle auquel on ajoute 2
        $weekNumber = date('W') + 2;
        $year = date('Y');
        $semaine_year = $weekNumber . '_' . $year;

        // on cherche s'il existe deja un menu pour cette date
        $menu = $this->menusRepository->findOneBy(['semaine_year' => $semaine_year]);

        // Si aucun menu n'est trouvé, créer un nouveau menu par défaut
        if (!$menu) {
            $menu = new Menus();
            $menu->setSemaineYear($semaine_year);
            $this->entityManager->persist($menu);
            $this->entityManager->flush();
        }
        // a partir d'ici, on inscrit automatiquement tous les utilisateurs de la base de données

        // recuperation de tous les utilisateurs
        $users = $this->userRepository->findall();

        //on boucle sur les utilisateurs
        foreach ($users as $user) {
            $relMenusUser = $this->relMenusUserRepository->findOneBy([
                'Menus' => $menu,
                'User' => $user
            ]);

            if (!$relMenusUser) {
                // recuperation du tableau d'inscription en fonction du status
                $tabinscription = (new StatusUser())->get_tabuser($user->getStatus());

                // creation de la table de jonction entre menu et user
                $RelMenusUser = new RelMenusUser();
                $RelMenusUser->setUser($user);
                $RelMenusUser->setMenus($menu);
                $RelMenusUser->setInscription($tabinscription);
                $this->entityManager->persist($RelMenusUser);
                $this->entityManager->flush();
            }

        }
        $output->writeln('Le menu a bien été créé et les élèves ont été inscrit par défaut.');

        return Command::SUCCESS;
    }
}