<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Request;


/// recuperation des donnees du formulaire d'inscription des eleves pour une semaine donnée : menuvalide
class Menuvalide
{

    // private $request;
    public function __construct(private Request $request)
    {

    }

    public function get_menuvalide()
    {


        $menu = array();
        for ($k = 0; $k < 2; $k++) {
            $tim = ["m", "s"][$k];
            for ($i = 1; $i < 8; $i++) {
                $menuvalide["btn_" . $tim . $i] = $this->request->request->get("btn_" . $tim . $i);
                // on met une condition dans le cas des demi pensionnaire qui ne voient pas les week-end (remplacement null->'off')
                if ($menuvalide["btn_" . $tim . $i] != 'on') {
                    $menuvalide["btn_" . $tim . $i] = 'off';
                }
            }
        }
        return $menuvalide;
    }

}