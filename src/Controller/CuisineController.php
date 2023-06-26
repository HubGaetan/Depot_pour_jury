<?php

namespace App\Controller;

use App\Models\Menuplats;
use App\Models\Gestion_date;
use App\Models\Recuperationdata;

use App\Services\Gestion_date_service;
use App\Services\Menuplats_service;

use App\Repository\UserRepository;
use App\Repository\MenusRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RelMenusUserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CuisineController extends AbstractController
{
    #[Route('/cuisine', name: 'app_cuisine')]
    public function index(): Response
    {
        return $this->render('cuisine/index.html.twig', [
            'controller_name' => 'CuisineController',
        ]);
    }

    #[Route('/cuisine/recuperation/{semaine_year}', name: 'app_cuisinerecuperation')]
    public function recuperation($semaine_year, RelMenusUserRepository $relrepository, Menuplats_service $Menuplats_service, MenusRepository $Menurepository, ManagerRegistry $doctrine, Gestion_date_service $gestionDate): Response
    {

        // recuperation de la date depuis le service Gestion_date_service
        [$semaine_year, $Date_recuperee] = $gestionDate->get_date($semaine_year);


        $menu = $Menurepository->findOneBy(['semaine_year' => $semaine_year]);


        $ElevesInscrits = $relrepository->findBy(['Menus' => $menu]);
        if ($ElevesInscrits) {

            $ListEleves = (new Recuperationdata())->get_data($ElevesInscrits);


            // conversion des id enregistrés en BDD en nom des plats
            [$Menu_AL, $Menu_AI] = $Menuplats_service->get_menuplats($menu, $doctrine);

            // [$Menu_AL, $Menu_AI] = (new Menuplats())->get_menuplats($menu,$doctrine);

            // dd($Id_eleves,$Inscriptions);
            // dd($ListEleves);
            return $this->render('cuisine/recuperation_inscription.html.twig', [
                'controller_name' => 'CuisineController',
                'Menu_A' => $Menu_AL,
                'ListEleves' => $ListEleves,
                'Date_recuperee' => $Date_recuperee
            ]);
        } else {

            $this->addFlash(
                'error',
                "le menu de la semaine $semaine_year n'existe pas ou l'enregistrement des élèves a connu un problème"
            );
            return $this->redirectToRoute('app_showmenu', ['semaine_year' => 'today']);


        }

    }

    // route permettant de voir les inscriptions des eleves pour les différentes semaine et générer les factures associées
    #[Route('/cuisine/facturation/{m_month_year}', name: 'app_cuisinefacturation')]
    public function facturation(
        $m_month_year,
        RelMenusUserRepository $relrepository,
        UserRepository $userrepository,
        MenusRepository $Menurepository,
        ManagerRegistry $doctrine,
        Gestion_date_service $gestionDate
    ): Response {
        // recuperation des semaines associées a un mois donné
        [$startDate, $endDate, $startWeek, $endWeek, $month, $year, $m_month_year] = $gestionDate->get_date_weeks_to_month($m_month_year);

        //[$startDate,$endDate,$startWeek,$endWeek,$month,$year]=(new Gestion_date())->get_date_weeks_to_month($m_month_year);


        // boucle sur les semaines trouvées pour le mois associé

        for ($week = $startWeek; $week <= $endWeek; $week++) {

            $semaine_year = $week . '_' . $year;


            //on recupere le menu de la semaine
            $menu = $Menurepository->findOneBy(['semaine_year' => $semaine_year]);

            //on recupere la liste des eleves inscrit cette semaine
            $ElevesInscrits = $relrepository->findBy(['Menus' => $menu]);

            // on boucle sur la liste des eleves inscrit a cette semaine la
            for ($i = 0; $i < sizeof($ElevesInscrits); $i++) {

                // recuperation des inscriptions
                $Inscriptions = $ElevesInscrits[$i]->getInscription();

                $Nb_Repas = (new Recuperationdata())->get_data_user($Inscriptions, $week, $month, $year);
                $email = $ElevesInscrits[$i]->getUser()->getEmail();

                if (!isset($Facture[$email])) {
                    $Facture[$email] = ['semaine' => [], 'somme' => 0];
                }

                // on enregistre dans le tableau facture, l'utilisateur, le numero de semaine et le nombre de repas associé
                $Facture[$email]['semaine'][$week] = $Nb_Repas;

                // on somme les repas sur les differentes semaine pour avoir le nombre de rapas au mois
                $Facture[$email]['somme'] += $Nb_Repas;


            }



        }
        return $this->render('cuisine/facturation.html.twig', [
            'Facture' => $Facture,
            'DateT' => [$startDate, $endDate],
            'weeks' => range($startWeek, $endWeek),
            'month' => $month,
            'year' => $year,
        ]);




    }
}