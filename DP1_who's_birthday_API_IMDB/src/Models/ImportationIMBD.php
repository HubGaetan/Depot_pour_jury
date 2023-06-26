<?php

namespace App\Models;

use App\Entity\Stars;
use App\Entity\DateStars;
use Doctrine\Persistence\ManagerRegistry;

// la class importation IMBD permet de faire une requete curl a l'API IMBD
// $doctrine -> permet de se connecter au manager de doctrine et de recuperer l'image objet de la base de données projetIMBD
// $Param -> int / string
// $param -> Date au format MD / "idIMDB"
// permet de recuperer soit la liste des stars idIMDB associée a Date
//    soit les infos pour la star idIMDB
class ImportationIMBD
{

    protected $Param; // mixed soit int pour la recherche dans la DateStarBDD
    // string pour id IMDB

    public function __construct(ManagerRegistry $doctrine, $Param)
    {
        $this->Param = $Param;
    }

    // fonction importationIMDB -> 
    //Importation depuis l'API IMDB de la liste des stars pour Date ou
    // des infos de la star id_IMDB
    public function importationIMDB()
    {

        if (is_int($this->Param)) {
            // reconverion int($date)->string($date)
            $DateS = strval($this->Param);
            if (strlen($DateS) == 3) {
                $Month = '0' . $DateS[0];
                $Day = $DateS[1] . $DateS[2];
            } else {
                $Month = $DateS[0] . $DateS[1];
                $Day = $DateS[2] . $DateS[3];
            }

            // importation depuis l'API IMBD par la requete HTTP :

            $url = "https://online-movie-database.p.rapidapi.com/actors/list-born-today?month=" . $Month . "&day=" . $Day;

            // utilisation de la class Curl pour procéder a l'importation
            $liste = new Curl_list($url);
            $res = $liste->get_list();
            // $_SESSION['liste'] = $res;
            return $res;

            // sinon si Param est une string (idIMDB)
        } elseif (is_string($this->Param)) {
            // Reconversion "/name/nmXXXXXX" -> "nmXXXXXXX"
            $TrimName = trim(str_replace("/name/", "", $this->Param), '/');

            // importation depuis l'API IMBD par la requete HTTP :

            $url = "https://online-movie-database.p.rapidapi.com/actors/get-bio?nconst=" . $TrimName;

            // utilisation de la class Curl pour procéder a l'importation
            $NewStar = new Curl_list($url);
            $ph2 = $NewStar->get_list();

            return $ph2;
        }
    }

    // focntion enregistrementDateStar
    // permet d'ecrire dans la Table Datestar la liste des idIMDB associée a Date
    public function enregistrementDateStar(ManagerRegistry $doctrine, $List)
    {
        foreach ($List as $Id) {
            $entityManager = $doctrine->getManager();
            $newDate = new DateStars();

            $newDate->setIdIMDB($Id);
            $newDate->setMD($this->Param);

            // ajouter l'operation d'insertion de la star dans la transaction

            $entityManager->persist($newDate);
            //execution de la transaction
            $entityManager->flush();
        }
    }

    // focntion enregistrementStar
    // permet d'ecrire dans la Table Star les infos de la Star idIMDB
    public function enregistrementStar(ManagerRegistry $doctrine, $ph)
    {

        $entityManager = $doctrine->getManager();

        $Stars = new Stars();


        $Stars->setIdIMDB($ph->id);
        $Stars->setname($ph->name);
        $Stars->setImageUrl($ph->image->url);
        $Stars->setBirthday($ph->birthDate);
        $Stars->setBirthplace($ph->birthPlace);
        if (isset($ph->heightCentimeters)) {
            $Stars->setHeight($ph->heightCentimeters);
        }
        $Stars->setBiography($ph->miniBios[0]->text);
        $YMD = explode('-', $ph->birthDate);
        $Stars->setMD(intval($YMD[1] . $YMD[2]));
        $Stars->setYear(intval($YMD[0]));

        // ajouter l'operation d'insertion de la star dans la transaction

        $entityManager->persist($Stars);

        //execution de la transaction
        $entityManager->flush();

        return "enregistrement réussi";
    }
}