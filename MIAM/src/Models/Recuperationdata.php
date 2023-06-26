<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Request;


class Recuperationdata {


    public function get_data($ElevesInscrits)
    {
    
        $Id_eleves=[];
        $Inscriptions=[];
        for ($i=0 ; $i<sizeof($ElevesInscrits); $i++)
        {
            $Id_eleves[]=explode('@',$ElevesInscrits[$i]->getUser()->getEmail())[0];
            $Inscriptions[]=$ElevesInscrits[$i]->getInscription();
        }

        // for ($i=0 ; $i<sizeof($ElevesInscrits); $i++)
        $result = [];
        $ListELeves=[];
        $k=0;
foreach ($Inscriptions as $item) {
    foreach ($item as $key => $value) {
        if (strpos($key, 'btn_') === 0) {
            $index = str_replace('btn_', 'BTN_', $key);
            if (!isset($result[$index])) {
                $result[$index] = 0;
                $ListELeves[$index]=[];
            }

            if ($value === 'on') {
                $result[$index]++;
                $ListELeves[$index][]=$Id_eleves[$k];
            }
        }
    }
    $k++;
}
// dd($result,$ListELeves);
            return $ListELeves;
    }

    // renvoit le nombre de repas consommé dans la semaine
    public function get_data_user($inscriptions,$week,$month,$year)
    {
    // recuperation du premier jour de la premiere semaine
    $firstDayOfWeek = date('Y-m-d', strtotime($year . 'W' . $week . '1'));
    // initialisation du nombre repas pris    
    $Nb_repas=0;
    // Parcourt les jours de la semaine
    for ($i = 0; $i < 7; $i++) {
   
    $currentDay = date('Y-m-d', strtotime($firstDayOfWeek . ' +' . $i . ' day'));
    $currentDay2[] = date('Y-m-d', strtotime($firstDayOfWeek . ' +' . $i . ' day'));
    // on vérifie que ce jour appartient bien au mois
    // dd(intval(explode('-',$currentDay)[1]),intval($month));
     if (intval(explode('-',$currentDay)[1])===intval($month))
     {
        //on boucle sur midi et soir
        foreach (['m', 's'] as $prefix) 
        {        
        $repas= 'btn_'. $prefix . ($i+1);
            
        if ($inscriptions[$repas]=='on')
           {
            $Nb_repas++;
            } 
        }
    }

}
return $Nb_repas;

    //     $count = 0;
    // foreach ($data as $value) {
    //     if ($value === 'on') {
    //         $count++;
    //     }
    // }
    // return $count;
    }
    }
