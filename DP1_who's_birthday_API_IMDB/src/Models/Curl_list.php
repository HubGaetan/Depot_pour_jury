<?php

namespace App\Models;

/**
 * Summary of Curl_list
 */
class Curl_list
{
    public $url;
    /**
     * Summary of __construct
     * @param mixed $url : recuperation de l'url, ce qui va spécifier la requete faite a l'API IMDB
     * soit la récupération de la liste des stars nées un jour donné
     * soit la récupération des infos d'une star en particulier avec son IdIMDB
     * 
     * return un tableau soit la liste des IdIMDB pour une date donnée
     *                   soit les infos d'une star avec IdIMDB
     */
    public function __construct($url)
    {
        $this->url = trim($url, '/'); // permet de retirer les / en debut et fin de chaine
    }

    public function get_list()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: online-movie-database.p.rapidapi.com",
                "X-RapidAPI-Key: 3190233b3amsh38bea8a992f45cfp1d00e6jsn32077d5f2112"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            return json_decode($response, false);
        }
    }
}