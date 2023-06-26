<?php

namespace App\Controller;

use App\Entity\Plats;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class ExcelController extends AbstractController
{
    #[Route('/excel', name: 'app_excel')]
    public function index(EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load("excel/BDD_PLATS.xlsx");

        // dd($spreadsheet->getActiveSheet()->getCell('A60')->getValue());
        // die();
        $data = [];
        for ($i = 1; $i < 962; $i++) {
            if ($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue()) {
                $data[$i] =
                    [
                        $spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue(),
                        $spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue(),
                        $spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue()
                    ];
                $plat = new Plats();
                $plat->setNom($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue());
                $plat->setCalories(intval($spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue()));
                $plat->setIdCat($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue());

                $plat->setSlug($slugger->slug($plat->getNom()));
                $manager->persist($plat);
                $manager->flush();

            } else {
                break;
            }

        }


        // dd($data);
        return $this->render('excel/index.html.twig', [
            'controller_name' => 'ExcelController',
            // 'data' => $data
        ]);
    }
}