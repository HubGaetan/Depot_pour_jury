<?php

namespace App\Models;

use App\Models\Curl_list;

class AddStars
{

    //TODO remettre au propre avant de continuer....

    public function getStars()
    {
        // $url = "https://online-movie-database.p.rapidapi.com/actors/get-bio?nconst=nm0001467";
        // $photo = new Curl_list($url);
        // $ph = $photo->get_list();

        // $_SESSION["star1"] = $ph;

        $ph = $_SESSION["star1"];

        var_dump($_SESSION["star1"]);

        return $ph;
    }

    public function RecordStar($ph)
    {

        $ph = $_SESSION["star1"];
    }
}
