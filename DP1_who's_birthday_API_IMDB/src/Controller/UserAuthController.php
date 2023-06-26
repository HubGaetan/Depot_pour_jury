<?php

namespace App\Controller;

use App\Entity\Stars;
use App\Form\StarsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAuthController extends AbstractController
{
    #[Route('/user/auth', name: 'app_user_auth')]
    public function index(): Response
    {
        return $this->render('user_auth/index.html.twig', [
            'controller_name' => 'UserAuthController',
        ]);
    }

    #[Route('/user/auth/add/{Date}', name: 'app_user_auth')]
    public function add(ManagerRegistry $doctrine, Request $request, $Date, SluggerInterface $slugger): Response
    {
        // appel du manager de doctrine
        $entityManager = $doctrine->getManager();


        $Star = new Stars();
        // creation du formulaire a partir de StarsType
        $form = $this->createForm(StarsType::class, $Star);

        // utilisation de la méthode de form->handleRequest pour recupérer les infos dans le formulaire
        $form->handleRequest($request);

        // est ce que le formulaire a été rempli
        if ($form->isSubmitted()) {
            // si oui on ajoute la star a la BDDstars
            $IdIMDB = "/name/" . str_replace(" ", "", $Star->getname()) . $Star->getMD() . "/";
            $Star->setIdIMDB($IdIMDB);
            //$YMD = explode('-', $Star->getBirthday());
            $Star->setMD(intval($Date));

            if (strlen($Date) == 3) {
                $Month = '0' . $Date[0];
                $Day = $Date[1] . $Date[2];
            } else {
                $Month = $Date[0] . $Date[1];
                $Day = $Date[2] . $Date[3];
            }
            $BD = $Star->getYear() . "-" . $Month . "-" . $Day;
            $Star->setBirthday($BD);
            // $Star->setYear(intval($YMD[2]));

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

                // si oui on ajoute la star a la BDDstars
                $entityManager->persist($Star);
                $entityManager->flush();
            }
            $this->addFlash("success", $Star->getname() . " a été ajouté avec succès");

            return $this->redirectToRoute('app_home_page');
            ////


        } else {
            // renvoit du formulaire vers la vue et création de la vue du formulaire
            return $this->render('user_auth/add.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}