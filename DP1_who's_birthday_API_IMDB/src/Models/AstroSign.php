<?php

namespace App\Models;

/**
 * Summary of AstroSign
 */
class AstroSign
{

    private $DateStar;
    // definition de la correspondance entre les signes et les dates
    // la definition du temps se fait selon la methode "MMDD".
    private $TabSign = [
        "Verseau" => ["deb" => 121, "fin" => 219],
        "Poissons" => ["deb" => 220, "fin" => 320],
        "Bélier" => ["deb" => 321, "fin" => 420],
        "Taureau" => ["deb" => 421, "fin" => 520],
        "Gémeaux" => ["deb" => 521, "fin" => 621],
        "Cancer" => ["deb" => 622, "fin" => 722],
        "Lion" => ["deb" => 723, "fin" => 822],
        "Vierge" => ["deb" => 823, "fin" => 922],
        "Balance" => ["deb" => 923, "fin" => 1022],
        "Scorpion" => ["deb" => 1023, "fin" => 1122],
        "Sagittaire" => ["deb" => 1123, "fin" => 1221],
        "Capricorne" => ["deb" => 1222, "fin" => 120],
    ];



    public function __construct(int $DateStar)
    {
        $this->DateStar = $DateStar;
    }

    /**
     * Summary of Astroselect
     * Astroselect permet de récupérer le signe astrologique a partir de la date 
     * au format MMDD
     * @return string
     */
    public function Astroselect(): string
    {
        // boucle sur les signes
        foreach ($this->TabSign as $sign => $datesign) {
            // recherche de match
            if ($this->DateStar > $datesign["deb"] && $this->DateStar < $datesign["fin"]) {
                return $sign;
                // cas particulier du Capricorne
            } elseif ($sign == "Capricorne") {
                return ("Capricorne");
            }
        }
    }
}