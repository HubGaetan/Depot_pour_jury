<?php

namespace App\Models;

use App\Entity\Menus;
use App\Entity\Plats;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;



class Menutransform {

 
    // focntion permettant de transformer le tableau Menu_A en objet Menu_O
    public function menutransform($Menu_A,$semaine_year,$doctrine)
    {
    
       $Menu_OI=new Menus();
       $Menu_OL=new Menus();

        for ($i = 1; $i < 8; $i++) {
      
            for ($k = 0; $k < 2; $k++){
            $tim=["m","s"][$k];
            $MenuJI=[];
            $MenuJL=[];
           
           for ($j = 0; $j < 3; $j++) {
               $type = ["entree", "plat", "dessert"][$j];
                  
                    $AI=[];
                    $AL=[];
                   
              
                    foreach($Menu_A[$type."_" .$tim . $i] as $item)
                    {

                        // item est un string du type ID:42:jambon
                            // recuperation des id ou du nom des plats pre enregistré
                            // si il a un id (ie appartient a la BDD)
                            if (sizeof(explode(':',$item))>1)
                            
                            {
                            if ((((explode(':',$item))[1]) == "null"))
                            {
                              $manager = $doctrine->getManager();
                            $plats= new Plats();
                            // on lui definit son nom
                            $plats->setNom((explode(':',$item))[2]);

                            
                            // on l'enregistre dans la BDD
                            $manager->persist($plats);
                            $manager->flush();

                            // recuperation de l'id du nouveau plat
                            $repository = $doctrine->getRepository(Plats::class);
                            // recupération de l'objet plat
                            $plat = $repository->findOneBy(['nom' => (explode(':',$item))[2]]);

                            
                                // recuperation des id ou des nom des plats depuis la BDD
                            $AI[]= strval($plat->getid());      
                            $AL[]= $plat->getNom();    

                            $this->mise_a_jour_json(strval($plat->getid()), $plat->getNom());
                           
                            }
                              // sinon on l'enregistre dans la BDD
                            else
                            { 
                            // enregistrement du nouveau plat
                            $AI[]= (explode(':',$item))[1];
                            $AL[]= (explode(':',$item))[2];
                            
                            }
                          }
                     
                        
                    }
                    $Menu_AI[$type."_" .$tim . $i]=$AI;
                    $Menu_AL[$type."_" .$tim . $i]=$AL;

                    $MenuJI[]=$AI;
                    $MenuJL[]=$AL;
                }
                if ($k==0){
                    $Menu_OI->{"setM".$i}($MenuJI);
                    $Menu_OL->{"setM".$i}($MenuJL);
                } else {
                    $Menu_OI->{"setS".$i}($MenuJI);
                    $Menu_OL->{"setS".$i}($MenuJL);
                }
            }
        }
      
        // $Menu_O->setSemaineYear($date_recuperee[1] . "_" . $date_recuperee[2]);
        $Menu_OI->setSemaineYear($semaine_year);
        $Menu_OL->setSemaineYear($semaine_year);

      
        return([$Menu_OI,$Menu_OL,$Menu_AI,$Menu_AL]);
    }

    // public function menutransforminverse($Menu_OI,$Menu_OL)
    // {
    //   $menu_AI = [];
    //   $menu_AL = [];
    
 
    //     for ($i = 1; $i < 8; $i++) {
      
    //         for ($k = 0; $k < 2; $k++){
    //         $tim=["m","s"][$k];
    //         $timo=["M","S"][$k];
       
    //         $methodName = 'get'.$timo.$i;
    //        for ($j = 0; $j < 3; $j++) {
    //            $type = ["entree", "plat", "dessert"][$j];
    //            $Menu_AI[$type."_" .$tim . $i]=[];
    //               foreach (($Menu_OI->$methodName())[$j] as $item){
    //           $Menu_AI[$type."_" .$tim . $i][]= $item ;}
    //        }

    //        for ($j = 0; $j < 3; $j++) {
    //         $type = ["entree", "plat", "dessert"][$j];
    //         $Menu_AL[$type."_" .$tim . $i]=[];
    //            foreach (($Menu_OL->$methodName())[$j] as $item){
    //        $Menu_AL[$type."_" .$tim . $i][]= $item ;}
    //     }

       
    //       }
    //     }
    //     // dd($Menu_AI,$Menu_AL);
    //     $menuArray = [];
    //     for ($i = 1; $i < 8; $i++) {
      
    //       for ($k = 0; $k < 2; $k++){
    //       $tim=["m","s"][$k];
          
    //      for ($j = 0; $j < 3; $j++) {
    //          $type = ["entree", "plat", "dessert"][$j];
    //         // $menuArray[$type."_" .$tim . $i]=[];
    //          $mergedSubArray=[];
    //          if ( array_key_exists($type."_" .$tim . $i, $Menu_AL))
    //          { 
             
    //          for ($h=0; $h<count($Menu_AL[$type."_" .$tim . $i]);$h++)
    //          {
    //           $id = $Menu_AI[$type."_" .$tim . $i][$h];
    //           $nom = $Menu_AL[$type."_" .$tim . $i][$h];
    //           $mergedSubArray[] = $id . ":" . $nom;
    //          }
            
    //         }
    //         $menuArray[$type."_" .$tim . $i][$j] = $mergedSubArray;
    //      }
    //     }
      
    //   }
    //   return([$menuArray,$Menu_AI,$Menu_AL]);
    // }

    public function mise_a_jour_menu($Menu,$Menu_OI){

      for ($i = 1; $i < 8; $i++) {
        foreach (['M', 'S'] as $prefix) {
            $getter = 'get' . $prefix . $i;
            $setter = 'set' . $prefix . $i;
            $Menu->$setter($Menu_OI->$getter());
        }
        }
    
    return $Menu;
    
    
    }


    // // fonction permettant de transformer un objet menu en tableau
    //   public function convertMenuObjectToArray($menu) {
    //     $menuArray = [];
    //     for ($i = 1; $i <= 7; $i++) {
    //       $methodName = 'getM'.$i;
    //       if (method_exists($menu, $methodName)) {
    //         $menuArray['M'.$i] = $menu->$methodName();
    //       }
    //       $methodName = 'getS'.$i;
    //       if (method_exists($menu, $methodName)) {
    //         $menuArray['S'.$i] = $menu->$methodName();
    //       }
    //     }
    //     return $menuArray;
    //   }

      // fonction permettant la mise a jour de plats.json
      public function mise_a_jour_json($id,$nom){
      // Charger le fichier JSON existant
    
        $jsonData = file_get_contents('plats.json');

// Convertir le contenu JSON en tableau associatif
        $data = json_decode($jsonData, true);

        $nouvellesDonnees = [
          [
               "id" => $id,
               "nom" => $nom,
                "calories" => "",
                "note" => null,
                "dernier_service" => null,
                "id_cat" => "",
                "slug" => $nom
         ]
            ];
            $data[2]['data'] = array_merge($data[2]['data'], $nouvellesDonnees);

// Convertir le tableau associatif mis à jour en JSON
            $jsonDataMisAJour = json_encode($data, JSON_PRETTY_PRINT);

// Écrire le JSON mis à jour dans le fichier plats.json
            file_put_contents('plats.json', $jsonDataMisAJour);
            
        }
}
