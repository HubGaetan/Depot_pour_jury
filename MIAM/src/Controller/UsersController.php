<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Menus;
use App\Models\tableau;
use App\Models\Menuplats;
use App\Models\Menuvalide;
use App\Models\SetProfile;
use App\Models\StatusUser;
use App\Entity\RelMenusUser;
use App\Models\Gestion_date;
use App\Services\PDFService;
use App\Services\Gestion_date_service;
use App\Services\Menuplats_service;

use App\Models\Recuperationdata;
use App\Repository\MenusRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RelMenusUserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/users')]
#[IsGranted("ROLE_USER")]

// Le user controller permet de controler l'ensemble des routes utilisateur 
class UsersController extends AbstractController
{
    #[Route('/', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }


    #[Route('/profile', name: 'app_usersprofile')]
    /**
     * route permettant d'acceder profil utilisateur
     *
     * @return Response affichage de la page profile
     */
    public function profile(): Response
    {

        $user = $this->getUser();
        $stat = $user->getStatus();

        if (!$stat) {
            $this->addFlash(
                'error',
                "votre status n'est pas défini, il est obligatoire !"
            );
        }


        return $this->render('users/profile.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    #[Route('/setprofile', name: 'app_setusersprofile')]
    /**
     * route d'enregistrment des modifications du profile utilisateur
     *
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function setprofile(ManagerRegistry $doctrine): Response
    {
        //recuperation de l'utilisateur connecté
        $user = $this->getUser();
        // enregistrement des informations
        $res = (new SetProfile())->set_profile_user($user, $doctrine);

        $this->addFlash(
            'success',
            'votre profil a bien été modifié'
        );

        return $this->redirectToRoute('app_usersprofile');
    }

    #[Route('/inscription/{semaine_year}', name: 'app_usersinscription')]
    /**
     * route permettant d'afficher la page d'inscription en prenant en compte le status du user actuellement connecté
     *
     * @param Menus $menu
     * @param ManagerRegistry $doctrine
     * @param string $semaine_year
     * @return Response
     */
    public function inscription(Menus $menu, ManagerRegistry $doctrine, Menuplats_service $Menuplats_service, $semaine_year = 'today', Gestion_date_service $gestionDate): Response
    {
        // $this->denyAccessUnlessGranted("ROLE_USER", null,'Access Denied.');
        // recuperation de l'utilisateur connecté
        $user = $this->getUser();

        // recuperation de son tableau d'inscription standard en fonction de son status ('Demi, Pens, PensComp,Ext)
        $tabinscription = (new StatusUser())->get_tabuser($user->getStatus());

        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // recuperation des données enragistrées en BDD pour le menu en question

        [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($menu, $doctrine);


        // affichage de la page d'inscription
        return $this->render('users/inscription.html.twig', [
            'controller_name' => 'UsersController',
            'Menu_A' => $Menu_AL,
            'Menu_AI' => $Menu_AI,
            'semaine_year' => $semaine_year,
            'Date_recuperee' => $Date_recuperee,
            'tabinscription' => $tabinscription
        ]);
    }


    #[Route('/validation/{semaine_year}', name: 'app_usersvalidation')]
    /**
     * cette route permet d'afficher la page de validation de l'eleve 
     *
     * @param Menus $menu
     * @param ManagerRegistry $doctrine
     * @param string $semaine_year
     * @param Request $request
     * @return Response
     */
    public function validation(Menus $menu, ManagerRegistry $doctrine, Menuplats_service $Menuplats_service, $semaine_year = 'today', Request $request, Gestion_date_service $gestionDate): Response
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // conversion des id enregistrés en BDD en nom des plats
        [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($menu, $doctrine);

        // recuperation des informations POST entrées par l'utilisateur
        $Menuvalide = (new Menuvalide($request))->get_menuvalide();

        $user = $this->getUser();
        // recuperation 
        $tabinscription = (new StatusUser())->get_tabuser($user->getStatus());
        $Menuvalide['NbJ'] = $tabinscription['NbJ'];

        $_SESSION['Menuvalide'] = $Menuvalide;

        return $this->render('users/validation_eleve.html.twig', [
            'controller_name' => 'UsersController',
            'Menu_A' => $Menu_AL,
            'Menu_AI' => $Menu_AI,
            'semaine_year' => $semaine_year,
            'Date_recuperee' => $Date_recuperee,
            'Menuvalide' => $Menuvalide
        ]);
    }


    #[Route('/enregistrement/{semaine_year}', name: 'app_usersenregistrement')]
    /**
     * route permettant d'enregistré/modifié les inscriptions définie par défaut
     *
     * @param Menus $Menu
     * @param ManagerRegistry $doctrine
     * @param string $semaine_year
     * @param RelMenusUserRepository $RelMenusUserRepository
     * @return Response
     */
    public function enregistrement(Menus $Menu, ManagerRegistry $doctrine, $semaine_year = 'today', RelMenusUserRepository $RelMenusUserRepository): Response
    {
        // recuperation du user
        $user = $this->getUser();

        // recuperation du menu_validé par l'eleve

        $Menuvalide = $_SESSION['Menuvalide'];

        // on recupere la relation dans la table jointe user menu 

        $RelMenusUser = $RelMenusUserRepository->findOneBy([
            'Menus' => $Menu,
            'User' => $user
        ]);

        // on modifie le tableau d'inscription
        $RelMenusUser->setInscription($Menuvalide);


        // on enregistre en BDD    
        $manager = $doctrine->getManager();
        $manager->persist($RelMenusUser);
        $manager->flush();


        $this->addFlash(
            'success',
            'votre inscription a bien été modifiée'
        );
        // on renvoit vers la page profile

        return $this->redirectToRoute('app_usersprofile');

        // return $this->render('users/validation_eleve.html.twig', [
        //     'controller_name' => 'UsersController',
        //     'Menu_A' => $Menu_AL,
        //     'Menu_AI' => $Menu_AI,
        //     'semaine_year' => $semaine_year,
        //     'Date_recuperee' => $Date_recuperee ,
        //     'Menuvalide' => $Menuvalide
        // ]);
    }
    #[Route('/viewinscription/{semaine_year}', name: 'app_usersviewinscription')]
    public function viewinscription(ManagerRegistry $doctrine, $semaine_year = 'today', Menuplats_service $Menuplats_service, RelMenusUserRepository $RelMenusUserRepository, MenusRepository $menusRepository, Gestion_date_service $gestionDate): Response
    {


        // recuperation des informations concernant la date
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);

        // recuperation de la semaine actuelle pour pouvoir conditionner la modification de l'inscription
        [$semaine_year_today, $Date_recuperee_today] = $gestionDate->get_date('today');


        // Chercher un menu existant dans la base de données pour la semaine et l'année spécifiées
        $Menu = $menusRepository->findOneBy(['semaine_year' => $semaine_year]);


        // recuperation du user
        $user = $this->getUser();


        if ($Menu) {


            // conversion des id enregistrés en BDD en nom des plats
            [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($Menu, $doctrine);
            // on recupere la relation dans la table jointe user menu 
            $RelMenusUser = $RelMenusUserRepository->findOneBy([
                'Menus' => $Menu,
                'User' => $user
            ]);

            //si elle existe
            if ($RelMenusUser) {
                $Menuvalide = $RelMenusUser->getInscription();


                return $this->render('users/viewinscription_eleve.html.twig', [
                    'controller_name' => 'UsersController',
                    'Menu_A' => $Menu_AL,
                    'Menu_AI' => $Menu_AI,
                    'semaine_year' => $semaine_year,
                    'Date_recuperee_today' => $Date_recuperee_today,
                    'Date_recuperee' => $Date_recuperee,
                    'Menuvalide' => $Menuvalide
                ]);
            } else {
                $this->addFlash(
                    'error',
                    "vous n'etes pas encore inscrit pour la $semaine_year "
                );
                return $this->redirectToRoute('app_users_inscription', ['semaine_year' => $semaine_year]);

            }

        } else {

            $this->addFlash(
                'error',
                "le menu de la semaine $Date_recuperee[1] n'a pas encore  été créé"
            );

            return $this->redirectToRoute('app_usersviewinscription', ['semaine_year' => 'today']);
        }
    }

    // route permettant de voir les inscriptions des eleves pour les différentes semaine et générer les factures associées
    #[Route('/facturation/{m_month_year}', name: 'app_usersfacturation')]
    public function facturationusers($m_month_year, RelMenusUserRepository $relrepository, MenusRepository $Menurepository, Gestion_date_service $gestionDate): Response
    {

        // on recupere l'utilisateur courant 
        $user = $this->getUser();


        // recuperation des informations concernant la date
        [$startDate, $endDate, $startWeek, $endWeek, $month, $year] = $gestionDate->get_date_weeks_to_month($m_month_year);

        // boucle sur les semaines trouvées pour le mois associé

        for ($week = $startWeek; $week <= $endWeek; $week++) {

            $semaine_year = $week . '_' . $year;

            //on recupere le menu de la semaine
            $menu = $Menurepository->findOneBy(['semaine_year' => $semaine_year]);


            if ($menu) {
                // on recupere la table jointe entre user et menus
                $RelMenusUser = $relrepository->findOneBy([
                    'Menus' => $menu,
                    'User' => $user
                ]);

                dd($week, $RelMenusUser);

                // recuperation des inscriptions
                $Inscriptions = $RelMenusUser->getInscription();


                $Nb_Repas = (new Recuperationdata())->get_data_user($Inscriptions, $week, $month, $year);
                $email = $user->getEmail();

                if (!isset($Facture[$email])) {
                    $Facture[$email] = ['semaine' => [], 'somme' => 0];
                }

                // on enregistre dans le tableau facture, l'utilisateur, le numero de semaine et le nombre de repas associé
                $Facture[$email]['semaine'][$week] = $Nb_Repas;

                // on somme les repas sur les differentes semaine pour avoir le nombre de rapas au mois
                $Facture[$email]['somme'] += $Nb_Repas;

            }

            // on enregistre en session les tableaux d'interet pour générer la facture sous format pdf
            $_SESSION['Facture'] = $Facture;
            $_SESSION['DateT'] = [$startDate, $endDate];
            $_SESSION['weeks'] = range($startWeek, $endWeek);



        }

        return $this->render('users/facturation.html.twig', [
            'Facture' => $Facture,
            'DateT' => [$startDate, $endDate],
            'weeks' => range($startWeek, $endWeek),
        ]);
    }

    // route depreciée

    // #[Route('/generatepdf', name: 'app_usersgeneratepdf')]
    // public function generatepdf(PDFService $pdf, KernelInterface $kernel): Response
    // {


    //     $html = $this->renderView('users/facturationPDF.html.twig', [
    //         'Facture' => $_SESSION['Facture'],
    //         'DateT' => $_SESSION['DateT'],
    //         'weeks' => $_SESSION['weeks'],
    //     ]);

    //     //  // Chemin et nom de fichier pour le fichier HTML
    //     //  $filePath = $kernel->getProjectDir() . '/public/assets/img/temp.html';

    //     //  $filePath=getcwd(). '\assets\img\temp.html';
    //     // //  dd($filePath);
    //     //  // Enregistre la chaîne HTML dans un fichier
    //     //  file_put_contents($filePath, $html);

    //     // // recuperation des infos
    //     // dd();
    //     $pdf->showPdf($html);
    // }

}