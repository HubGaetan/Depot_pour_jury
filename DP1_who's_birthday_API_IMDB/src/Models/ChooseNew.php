<?php

namespace App\Models;

use App\Models\GetStarBDD;
use App\Entity\DateStars;
use Doctrine\Persistence\ManagerRegistry;
use GetDateBDD;
use stdClass;

/**
 * Summary of ChooseNew
 */
class ChooseNew
{

    public $Datelist;
    public $Doctrine;
    public $date;

    public function __construct(ManagerRegistry $doctrine, $Datelist, $date)
    {
        $this->Datelist = $Datelist;
        $this->Doctrine = $doctrine;
        $this->date = $date;
    }


    /**
     * Summary of choosenew
     * la fonction choosenew permet de choisir une nouvelle star dans la liste de DateBDD
     * 
     * @return void
     */
    public function choosenew() // idIMDB nouvelle

    {
        $NewId = "";
        // recuperation de la liste des stars née le $this->date
        $ChosenDate = new GetDateBDD($this->Doctrine, $this->date);
        $ListeStarFound = $ChosenDate->getdatebdd();

        //recuperation de la liste des stars deja enregistréé dans la BDDStars pour $this->date
        $CheckStar = new GetStarBDD($this->Doctrine);
        $StarFound = $CheckStar->getstarbdd($this->date);


        if ($StarFound == ["0" => []]) {
            // si la liste des stars est vide, on importe la premiere star de la liste 
            $Import = new ImportationIMBD($this->Doctrine, $ListeStarFound[0]->IdIMDB);
            // importation depuis l'API IMDB
            $NewStar = $Import->importationIMDB();
            // enregistrement de la star dans la BDDStar
            $message = $Import->enregistrementStar($this->Doctrine, $NewStar);
        } else {

            // si la liste des stars n'est pas vide :
            //creation d'un tableau avec les IdIMDB trouvée
            for ($i = 0; $i < count($StarFound); $i++) {
                $Tab_StarFound[] = $StarFound[$i]->idIMDB;
            }
            // creation d'un tableau avec la liste complete des stars nées ce jour la
            for ($i = 0; $i < count($ListeStarFound); $i++) {
                $Tab_ListeStarFound[] = $ListeStarFound[$i]->IdIMDB;
            }
            // calcul de la différence entre les 2 tableaux

            $Difference = array_diff($Tab_ListeStarFound, $Tab_StarFound);
            // on recupére l'IdIMDB suivant
            $NewId = $Difference[count($Tab_StarFound)];
            // importation d'une nouvelle star

            $Import = new ImportationIMBD($this->Doctrine, $NewId);
            $NewStar = $Import->importationIMDB();

            // enregistrement de la star dans la BDDstar
            $message = $Import->enregistrementStar($this->Doctrine, $NewStar);
        }
    }
}