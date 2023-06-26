<?php

/**
 * Summary of GetDay
 */
class GetDay
{

    /**
     * Summary of getday
     * getday permet de convertir la date récupérer au format MMDD
     * @return int
     */
    public function getday()
    {
        // recuperation de la Date si définie 
        if (!empty($_GET)) {
            $Date = $_GET['ChosenDay'];
            //conversion de la Date au format MMDD
            if (is_string($Date) && strlen($Date) > 4) {
                $temp = explode('-', $Date);
                $dateS = intval($temp[1] . $temp[2]);
            } else {
                $dateS = intval($Date);
            }

            // sinon Date = Today
        } else {
            $Today = explode('.', date("m.d.y"));
            $dateS = intval($Today[0] . $Today[1]);
        }

        return $dateS;
    }

    /**
     * Summary of CheckDate
     * Check Date permet de récupérer la date au format (Y-m-d) (string)
     * @return mixed
     */
    public function CheckDate()
    {
        if (!empty($_GET)) {
            $DateC = $_GET['ChosenDay'];
        } else {
            $DateC = date("Y-m-d");
        }
        return $DateC;

    }
}