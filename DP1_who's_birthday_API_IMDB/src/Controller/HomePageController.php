<?php

namespace App\Controller;

use GetDay;
use doctrine;
use App\Entity\Stars;
use App\Models\Curl_list;
use App\Models\GetStarBDD;
use App\Service\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        // recuperer la Date choisie et la convertir au format MD / default : today
        // $DateT = (new GetDay())->getday();
        $DateT = new GetDay();
        $Date = $DateT->getday();

        $DateC = $DateT->CheckDate();

        // Chercher dans la BDD stars les stars pour Date
        $StarF = (new GetStarBDD($doctrine));
        $StarFound = $StarF->getstarbdd($Date);

        // compte du nombre de stars trouvées
        $NbStarFound = count($StarFound);


        // afficher les StarFound pour Date
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'date' => $Date,
            'DateString' => $DateC,
            'starfound' => $StarFound,
            'NbStarFound' => $NbStarFound
        ]);
    }

    #[Route('/testmail', name: 'testmail')]
    public function mailing(MailerService $mailer)
    {

        $mailer->sendEmail();

        dd($mailer->sendEmail());
        return $this->render('home_page/index.html.twig');
        var_dump("mais quel bogoss");
    }


    #[Route('/template', name: '_tapp_home_page')]
    public function template(): Response
    {
        $Today = explode('.', date("m.d.y"));
        $url = "https://online-movie-database.p.rapidapi.com/actors/list-born-today?month=" . $Today[0] . "&day=" . $Today[1];
        $liste = new Curl_list($url);
        $res = $liste->get_list();
        $TRE = [];
        foreach ($res as $re) {
            $re = trim(str_replace("/name/", "", $re), "/");
            $TRE[] = $re;
        }

        // %% get-all-images?nconst=
        // var_dump($TRE);
        // $url = "https://online-movie-database.p.rapidapi.com/actors/get-all-images?nconst=" . $TRE[0];

        // $photo = new Curl_list($url);
        // $ph = $photo->get_list();
        // $photourl = $ph["resource"]["images"][3]["url"];
        // kevin cosner "https://m.media-amazon.com/images/M/MV5BMTY1ODkwMTQxOF5BMl5BanBnXkFtZTcwNzkwNDcyMw@@._V1_.jpg"
        $url = "https://online-movie-database.p.rapidapi.com/actors/get-bio?nconst=" . $TRE[1];

        $photo = new Curl_list($url);
        $ph = $photo->get_list();
        $photourl = $ph["image"]["url"];

        //   dd($photourl);




        return $this->render('base.html.twig', [
            'photo' => $photourl,
            'liste' => $res
        ]);
    }
}