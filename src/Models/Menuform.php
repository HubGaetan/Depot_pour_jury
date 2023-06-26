<?php

namespace App\Models;

class Menuform
{

    // recuperation des informations post provenant du formulaire de menu
    public function get_menu()
    {
        $menu = array();
        for ($k = 0; $k < 2; $k++) {
            $tim = ["m", "s"][$k];
            for ($j = 0; $j < 3; $j++) {
                $type = ["entree", "plat", "dessert"][$j];
                for ($i = 1; $i < 8; $i++) {
                    //  $menu[$type."_". $tim .$i] = $this->request->request->get($type."_".$tim.$i);
                    $menu[$type . "_" . $tim . $i] = $_POST[$type . "_" . $tim . $i];
                }
            }
        }
        return $menu;
    }
}