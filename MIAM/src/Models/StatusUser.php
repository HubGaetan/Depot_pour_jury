<?php

namespace App\Models;

// definition des différents statut et leur correspondance avec leur table d'inscription
class StatusUser
{
    private $Demi = [
        'NbJ' => 5,
        'btn_m1' => 'on',
        'btn_m2' => 'on',
        'btn_m3' => 'on',
        'btn_m4' => 'off',
        'btn_m5' => 'on',
        'btn_m6' => 'off',
        'btn_m7' => 'off',
        'btn_s1' => 'off',
        'btn_s2' => 'off',
        'btn_s3' => 'off',
        'btn_s4' => 'off',
        'btn_s5' => 'off',
        'btn_s6' => 'off',
        'btn_s7' => 'off'
    ];

    private $Ext = [
        'NbJ' => 5,
        'btn_m1' => 'off',
        'btn_m2' => 'off',
        'btn_m3' => 'off',
        'btn_m4' => 'off',
        'btn_m5' => 'off',
        'btn_m6' => 'off',
        'btn_m7' => 'off',
        'btn_s1' => 'off',
        'btn_s2' => 'off',
        'btn_s3' => 'off',
        'btn_s4' => 'off',
        'btn_s5' => 'off',
        'btn_s6' => 'off',
        'btn_s7' => 'off'
    ];

    private $PensComp = [
        'NbJ' => 7,
        'btn_m1' => 'on',
        'btn_m2' => 'on',
        'btn_m3' => 'on',
        'btn_m4' => 'on',
        'btn_m5' => 'on',
        'btn_m6' => 'on',
        'btn_m7' => 'on',
        'btn_s1' => 'on',
        'btn_s2' => 'on',
        'btn_s3' => 'on',
        'btn_s4' => 'on',
        'btn_s5' => 'on',
        'btn_s6' => 'on',
        'btn_s7' => 'on'
    ];

    private $Pens = [
        'NbJ' => 5,
        'btn_m1' => 'on',
        'btn_m2' => 'on',
        'btn_m3' => 'on',
        'btn_m4' => 'on',
        'btn_m5' => 'on',
        'btn_m6' => 'off',
        'btn_m7' => 'off',
        'btn_s1' => 'on',
        'btn_s2' => 'on',
        'btn_s3' => 'on',
        'btn_s4' => 'on',
        'btn_s5' => 'off',
        'btn_s6' => 'off',
        'btn_s7' => 'off'
    ];

    // getter
    function get_tabuser($cas)
    {
        switch ($cas) {
            case 'Demi': // demipensionnaire
                return $this->Demi;
            case 'Ext': // externe
                return $this->Ext;
            case 'Pens': // pensionnaire mais pas le week-end
                return $this->Pens;
            case 'PensComp': // pension complete
                return $this->PensComp;
            default:
                return null; // Renvoyer null si le cas n'existe pas
        }
    }
}