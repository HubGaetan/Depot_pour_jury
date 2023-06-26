<?php

namespace App\Services;

use App\Entity\Menus;
use App\Entity\Plats;


class Menuplats_service
{
    // fonction permettant de transformer l'objet Menu contenant les id des plats en tableau contenant le nom des plats
    public function get_menuplats($Menu_O, $doctrine)
    {

        $repositoryplats = $doctrine->getRepository(Plats::class);


        // On récupère le repository des plats
// On boucle sur les 7 attributs M1, M2, ..., M7
        for ($i = 1; $i <= 7; $i++) {
            $menuArray = $Menu_O->{'getM' . $i}();
            $tim = 'm';


            for ($j = 0; $j < 3; $j++) {
                $type = ["entree", "plat", "dessert"][$j];
                $Menu_AL[$type . "_" . $tim . $i] = [];
                $Menu_AI[$type . "_" . $tim . $i] = [];

                if (sizeof($menuArray) > 0) {
                    // On boucle sur les 3 tableaux d'entiers  

                    $dishIds = $menuArray[$j];
                    $dishNames = [];

                    // On boucle sur les identifiants des plats
                    foreach ($dishIds as $dishId) {
                        $dish = $repositoryplats->find($dishId);

                        // On stocke le nom du plat correspondant
                        if ($dish) {
                            // $dishNames[] = $dish->getNom();
                            $Menu_AL[$type . "_" . $tim . $i][] = $dish->getNom();
                            $Menu_AI[$type . "_" . $tim . $i][] = $dish->getid();
                        }
                    }

                    // On remplace les identifiants par les noms des plats
                    $menuArray[$j] = $dishNames;

                } else {
                    $Menu_AL[$type . "_" . $tim . $i] = [];
                    $Menu_AI[$type . "_" . $tim . $i] = [];


                }
            }
        }

        for ($i = 1; $i <= 7; $i++) {
            $menuArray = $Menu_O->{'getS' . $i}();
            $tim = 's';


            for ($j = 0; $j < 3; $j++) {
                $type = ["entree", "plat", "dessert"][$j];
                $Menu_AL[$type . "_" . $tim . $i] = [];
                $Menu_AI[$type . "_" . $tim . $i] = [];

                if (sizeof($menuArray) > 0) {
                    // On boucle sur les 3 tableaux d'entiers


                    $dishIds = $menuArray[$j];
                    $dishNames = [];

                    // On boucle sur les identifiants des plats
                    foreach ($dishIds as $dishId) {
                        $dish = $repositoryplats->find($dishId);

                        // On stocke le nom du plat correspondant
                        if ($dish) {
                            // $dishNames[] = $dish->getNom();
                            $Menu_AL[$type . "_" . $tim . $i][] = $dish->getNom();
                            $Menu_AI[$type . "_" . $tim . $i][] = $dish->getid();
                        }
                    }

                    // On remplace les identifiants par les noms des plats
                    $menuArray[$j] = $dishNames;

                } else {
                    $Menu_AL[$type . "_" . $tim . $i] = [];
                    $Menu_AI[$type . "_" . $tim . $i] = [];

                }
            }
        }

        return ([$Menu_AL, $Menu_AI]);
    }

}