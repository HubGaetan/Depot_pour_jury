<?php
//TODO = 1
namespace App\Controller;

use App\Entity\Menus;

// use Spipu\Html2Pdf\Html2Pdf;

use App\Models\Menuform;
use App\Models\Menuplats;
use App\Models\Menuvalide;
use App\Models\StatusUser;
use App\Entity\RelMenusUser;
use App\Models\Gestion_date;
use App\Services\Gestion_date_service;
use App\Services\Menuplats_service;

use App\Models\Menutransform;


use App\Repository\UserRepository;
use App\Repository\MenusRepository;
use App\Models\Menufromposttoobject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RelMenusUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    #[is_granted('ROLE_USER')]
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login');

    }

    #[is_granted('ROLE_USER')]
    #[Route('/showmenu/{semaine_year}', name: 'app_showmenu')]
    public function showmenu($semaine_year = 'today', ManagerRegistry $doctrine, Gestion_date_service $gestionDate, Menuplats_service $Menuplats_service): Response
    {
        // recuperation de la date depuis le service Gestion_date_service
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // on cherche dans le repository si le menu existe
        $repository = $doctrine->getRepository(Menus::class);

        // recupération de l'objet Menu
        $menu = $repository->findOneBy(['semaine_year' => $semaine_year]);
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        if (!$menu) {
            if ($this->isGranted('ROLE_CUISINE')) {
                // Si l'utilisateur a le rôle cuisine, on redirige vers la page de création de menu
                return $this->redirectToRoute('app_editmenu', ['semaine_year' => $semaine_year]);
            } else {
                // Si l'utilisateur a le rôle utilisateur, on redirige vers la page d'affichage de menu du jour
                return $this->redirectToRoute('app_showmenu');
            }
        }

        // conversion des id enregistrés en BDD en nom des plats
        [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($menu, $doctrine);
        // [$Menu_AL1, $Menu_AI1] = (new Menuplats())->get_menuplats($menu,$doctrine);

        // $html = $this->render('menu/show.html.twig', [
        //     'controller_name' => 'MenuController',
        //     'Menu_A' => $Menu_AL,
        //     'Menu_AI' => $Menu_AI,
        //     'Date_recuperee' => $Date_recuperee

        // ]);
        // $html2pdf = new Html2Pdf();
        // $html2pdf->writeHTML($html);
        // $html2pdf->output("tac.pdf");
        // Affichage de la page du menu pour la semaine sélectionnée

        return $this->render('menu/show.html.twig', [
            'controller_name' => 'MenuController',
            'Menu_A' => $Menu_AL,
            'Menu_AI' => $Menu_AI,
            'Date_recuperee' => $Date_recuperee

        ]);
    }



    // 

    #[Route('/editmenu/{semaine_year}', name: 'app_editmenu')]
    /**
     * Route permettant de creer ou de modifier un menu existant
     *
     * @param string $semaine_year
     * @param ManagerRegistry $doctrine
     * @param MenusRepository $menusRepository
     * @return Response
     */
    public function editmenu($semaine_year, ManagerRegistry $doctrine, MenusRepository $menusRepository, Gestion_date_service $gestionDate, Menuplats_service $Menuplats_service): Response
    {
        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // securisation de la route pour le user CUISINE

        $this->denyAccessUnlessGranted('ROLE_CUISINE', null, 'Access Denied.');

        // Chercher un menu existant dans la base de données pour la semaine et l'année spécifiées
        $menu = $menusRepository->findOneBy(['semaine_year' => $semaine_year]);

        // Si aucun menu n'est trouvé, créer un nouveau menu par défaut
        if (!$menu) {
            $menu = new Menus();
            $menu->setSemaineYear($semaine_year);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($menu);
            $entityManager->flush();

        }
        // fonction permettant de transformer l'objet Menu en 2 tableaux :
        // Menu_AL -> contenant le nom des plats
        // Menu_AI -> contenant l'id des plats
        // [$Menu_AL, $Menu_AI] = (new Menuplats())->get_menuplats($menu,$doctrine);

        // conversion des id enregistrés en BDD en nom des plats
        [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($menu, $doctrine);

        // affichage du editmenu pre-rempli avec les data enregistrées en BDD ou vide si nouveau

        return $this->render('menu/editmenu.html.twig', [
            'controller_name' => 'MenuController',
            'Date_recuperee' => $Date_recuperee,
            'semaine_year' => $semaine_year,
            'Menu_A' => $Menu_AL,
            'Menu_AI' => $Menu_AI
        ]);
    }


    #[Route('/validatemenu/{semaine_year}', name: 'app_validatemenu')]
    /**
     * validate menu permet d'afficher la page avec les données rentrées par la cuisine
     *
     * @param string $semaine_year
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return Response
     */
    public function validate_menu($semaine_year, ManagerRegistry $doctrine, Gestion_date_service $gestionDate): Response
    {

        // securisation de la route pour le user CUISINE
        $this->denyAccessUnlessGranted('ROLE_CUISINE', null, 'Access Denied.');

        // Demarrage d'une session si nécessaire
        if (!isset($_SESSION)) {
            session_start();
        }


        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // recuperation dans un tableau des infos POST du menu
        $Menu_A = (new Menuform())->get_menu();


        // transformation du tableau $Menu_A : 
        // en 2 objets contenant les indices et les noms 
        // en 2 tableaux contenant les indices et les noms  

        [$Menu_OI, $Menu_OL, $Menu_AI, $Menu_AL] = (new Menutransform())->menutransform($Menu_A, $semaine_year, $doctrine);



        // enregistrement en session de l'objet Menu_OI
        $_SESSION["menu_OI"] = $Menu_OI;
        $_SESSION["menu_AL"] = $Menu_AL;
        // $_SESSION["menu_OL"]= $Menu_OL;


        // renvoit la page d'affichage de validation du menu
        return $this->render('menu/validation_cuisine.html.twig', [
            'controller_name' => 'MenuController',
            'Menu_A' => $Menu_AL,
            'Date_recuperee' => $Date_recuperee,
            'semaine_year' => $semaine_year

        ]);
    }

    // 
    #[Route('/menuformenregistrement/{semaine_year}', name: 'app_menuformenregistrement')]
    /**
     * route menuformenregistrement permettant l'enregistrement en BDD
     *
     * @param ManagerRegistry $doctrine
     * @param [type] $semaine_year
     * @param [type] $Menu
     * @param UserRepository $UserRepository
     * @param RelMenusUserRepository $RelMenusUserRepository
     * @return Response
     */
    public function menuformenregistrement(ManagerRegistry $doctrine, Gestion_date_service $gestionDate, $semaine_year, Menus $Menu = new Menus(), UserRepository $UserRepository, RelMenusUserRepository $RelMenusUserRepository): Response
    {

        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);
        // securisation de la route pour le user CUISINE
        $this->denyAccessUnlessGranted('ROLE_CUISINE', null, 'Access Denied.');

        // recuperation du menu en cours de modification avec le param_converter

        // ouverture du manager de doctrine
        $manager = $doctrine->getManager();

        // on recupere le menu objet dans la version indice
        $Menu_OI = $_SESSION["menu_OI"];
        $Menu_AL = $_SESSION["menu_AL"];
        // $Menu_OL= $_SESSION["menu_OL"];

        // mise a jour du menu:
        $Newmenu = (new Menutransform())->mise_a_jour_menu($Menu, $Menu_OI);

        // // on retire le Menu initialement enregistré
        // $manager->remove($Menu);
        // $manager->flush();
        // on le remplace par le menu modifié
        $manager->persist($Newmenu);
        $manager->flush();
        //  
        // dd('caca');
        $this->addFlash(
            'success',
            'le menu a bien été enregistré !'
        );

        return $this->redirectToRoute('app_showmenu', ['semaine_year' => $semaine_year]);

        // return $this->render('menu/envoi_cuisine.html.twig', [
        //     'controller_name' => 'MenuController',
        //     'Menu_A' => $Menu_AL,
        //     'Date_recuperee' => $Date_recuperee,
        //     'semaine_year' => $semaine_year

        // ]);

        // return $this->redirectToRoute('app_showmenu', ['semaine_year' => $semaine_year]);


    }



    #[Route('/menuenvoi/{semaine_year}', name: 'app_menuenvoi')]
    /**
     * route permettant d'enregistrer automatiquement les eleves en fonction de leur status pardéfaut
     *
     * @param ManagerRegistry $doctrine
     * @param string $semaine_year
     * @param Menus $Menu
     * @param UserRepository $UserRepository
     * @param RelMenusUserRepository $RelMenusUserRepository
     * @return Response
     */
    public function menuenvoi(ManagerRegistry $doctrine, $semaine_year, Menus $Menu, UserRepository $UserRepository, RelMenusUserRepository $RelMenusUserRepository): Response
    {
        // recuperation du manager
        $manager = $doctrine->getManager();
        // recuperation de tous les utilisateurs
        $users = $UserRepository->findall();

        foreach ($users as $user) {
            $relMenusUser = $RelMenusUserRepository->findOneBy([
                'Menus' => $Menu,
                'User' => $user
            ]);

            if (!$relMenusUser) {
                // recuperation du tableau d'inscription en fonction du status
                $tabinscription = (new StatusUser())->get_tabuser($user->getStatus());

                // creation de la table de jonction entre menu et user
                $RelMenusUser = new RelMenusUser();
                $RelMenusUser->setUser($user);
                $RelMenusUser->setMenus($Menu);
                $RelMenusUser->setInscription($tabinscription);
                $manager->persist($RelMenusUser);
                $manager->flush();
            }



        }
        // renvoyer vers la page profil cuisine //TODO
        return $this->redirectToRoute('app_showmenu', ['semaine_year' => $semaine_year]);
    }

}