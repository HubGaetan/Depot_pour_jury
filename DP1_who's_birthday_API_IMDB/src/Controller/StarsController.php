<?php


namespace App\Controller;

use GetDay;
use doctrine;
use GetDateBDD;
use App\Entity\Stars;
use App\Form\StarsType;
use App\Models\GetStar;
use App\Models\AddStars;
use App\Models\AstroSign;
use App\Models\ChooseNew;
use App\Models\GetStarBDD;
use App\Service\PdfService;
use App\Models\ImportationIMBD;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Summary of StarsController
 */
class StarsController extends AbstractController
{
    // affichage des stars
    #[Route('/stars/{IdIMDB}', name: 'app_stars')]
    /**
     * Summary of index
     * renvoit les informations d'une star donnée (idIMDB) a la vue de detail associée
     * @param doctrine\Persistence\ManagerRegistry $doctrine
     * @param mixed $IdIMDB
     * @param PdfService $pdf
     * @return Response
     */
    public function index(ManagerRegistry $doctrine, $IdIMDB, PdfService $pdf): Response
    {

        // reconversion du nom au format de l'enregistrment de la BDD

        $IdIMDB = "/name/" . $IdIMDB . '/';


        // récupération des infos de la star
        $StarF = (new GetStar($doctrine, $IdIMDB));
        $StarFound = $StarF->getstar();

        // récupération de son signe astro
        $SignAstro = (new AstroSign($StarFound[0]->MD))->Astroselect();

        // render
        return $this->render('stars/index.html.twig', [
            'controller_name' => 'StarsController',
            'StarFound' => $StarFound,
            'SignAstro' => $SignAstro
        ]);
        // $html = $this->render('stars/index.html.twig', [
        //     'controller_name' => 'StarsController',
        //     'StarFound' => $StarFound,
        //     'SignAstro' => $SignAstro
        // ]);

        // $pdf->showPdf($html);

        // return $html;
    }

    #[Route('/stars/add/{Date}', name: 'app_stars_add')]
    public function add(ManagerRegistry $doctrine, $Date): Response
    {

        session_start();
        //Recherche dans la BDD DateStar, (est ce que la Date recherchée est deja présente)
        $DateF = new GetDateBDD($doctrine, intval($Date));
        $DateFound = $DateF->getdatebdd(); // renvoit la liste des idIMDB pour $Date

        // Si la Date n'existe pas dans la BDD DateStar
        if ($DateFound == ["0" => []]) {
            // Importation depuis API IMBD de la liste des idIMDB pour Date

            $NewDate = new ImportationIMBD($doctrine, intval($Date));
            $List = $NewDate->importationIMDB();

            // enregistrement dans la BDD DateStar
            $NewDate->enregistrementDateStar($doctrine, $List);
            $this->addFlash('success', "Le calendrier des stars a été mis a jour. Veuillez cliquer pour decouvrir votre star du jour");
            // Si la Date existe dans la table DateStar
        } else {

            // Choix d'un nouveau idIMDB dans la liste DateFound

            $newChoice = new ChooseNew($doctrine, $DateFound, $Date);
            $newIdIMDB = $newChoice->choosenew();
        }



        return $this->redirectToRoute('app_home_page', ["ChosenDay" => $Date]);
    }

    #[Route('/stars/edit/{IdIMDB}', name: 'edit_stars')]
    /**
     * Summary of edit
     * permet d'editer une star
     * @param doctrine\Persistence\ManagerRegistry $doctrine
     * @param mixed $IdIMDB
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function edit(ManagerRegistry $doctrine, $IdIMDB, Request $request, SluggerInterface $slugger)
    {
        // dd($doctrine, $IdIMDB);


        $IdIMDB = "/name/" . $IdIMDB . '/';
        $entityManager = $doctrine->getManager();


        $Star = (new GetStarBDD($doctrine))->getstarIMDB($IdIMDB);


        // creation du formulaire a partir de StarsType
        $form = $this->createForm(StarsType::class, $Star);

        // utilisation de la méthode de form->handleRequest pour recupérer les infos dans le formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('star_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $FullFilename = "uploads/stars/" . $newFilename;
                $Star->setImage($FullFilename);
            }
            // si oui on ajoute la star a la BDDstars
            $entityManager->persist($Star);
            $entityManager->flush();

            $this->addFlash("success", $Star->getname() . " a été modifié avec succès");

            return $this->redirectToRoute('app_home_page');
        } else {
            // renvoit du formulaire vers la vue et création de la vue du formulaire
            return $this->render('user_auth/add.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/stars/checkstars', name: 'app_stars_check')]
    public function checkstars(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Stars::class);
        $StarFound = $repository->findBy(['idIMDB' => '/name/nm0001467/']);

        $form = "Definir une date";
        // unset($_GET);
        if (!empty($_GET)) {
            $form = $_GET['ChosenDay'];
        }
        $temp = explode('-', $form);

        $dateS = intval($temp[1] . $temp[2]);

        $StarSign = new AstroSign($dateS);
        $SignMatch = $StarSign->AstroSelect();





        return $this->render('test.html.twig', [
            'stars' => $StarFound[0],
            'SignStar' => $SignMatch,
            'formS' => $form


        ]);
    }

    #[Route('/stars/addBDD', name: 'app_stars_addBDD')]

    /** */
    /**
     * Summary of addBDD
     * @param doctrine\Persistence\ManagerRegistry $doctrine
     * @return Response
     */
    public function addBDD(ManagerRegistry $doctrine): Response
    {
        session_start();
        $ph = $_SESSION["star1"];


        $entityManager = $doctrine->getManager();

        $Stars = new Stars();


        $Stars->setIdIMDB($ph->id);
        $Stars->setname($ph->name);
        $Stars->setImageUrl($ph->image->url);
        $Stars->setBirthday($ph->birthDate);
        $Stars->setBirthplace($ph->birthPlace);
        $Stars->setHeight($ph->heightCentimeters);
        $Stars->setBiography($ph->miniBios[0]->text);
        $YMD = explode('-', $ph->birthDate);
        $Stars->setMD(intval($YMD[1] . $YMD[2]));
        $Stars->setYear(intval($YMD[0]));

        // ajouter l'operation d'insertion de la star dans la transaction

        $entityManager->persist($Stars);

        //execution de la transaction
        $entityManager->flush();




        return $this->render('test.html.twig', [
            'stars' => $ph
        ]);
    }
}