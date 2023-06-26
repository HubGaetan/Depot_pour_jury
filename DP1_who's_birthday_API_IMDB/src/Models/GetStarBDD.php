<?php

namespace App\Models;

use doctrine;
use App\Entity\Stars;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * Summary of GetStarBDD
 */
class GetStarBDD
{
    public $StarFound;
    public $doctrine;
    //public $date;

    public function __construct($doctrine) //, $date)

    {
        $this->doctrine = $doctrine;
        // $this->date = $date;
    }
    /**
     * Summary of getstarbdd
     * @param mixed $date
     * @return array<array>|mixed
     */
    public function getstarbdd($date)
    {
        // recuperation des informations dans le Repository Stars
        $repository = $this->doctrine->getRepository(Stars::class);

        // Selection des Stars en focntion de la Date
        $this->StarFound = $repository->findBy(['MD' => $date]);

        // Renvoit des resultats de la recherche
        if (empty($this->StarFound)) {
            return ["0" => []];
        } else {
            return $this->StarFound;
        }
    }

    public function getstarIMDB($IdIMDB)
    {
        // recuperation des informations dans le Repository Stars
        $repository = $this->doctrine->getRepository(Stars::class);

        // Selection des Star en focntion de la Date
        // $this->StarFound = $repository->findBy(['idIMDB' => $IdIMDB]);
        $this->StarFound = $repository->findOneBy(['idIMDB' => $IdIMDB]);



        // Renvoit des resultats de la recherche
        if (empty($this->StarFound)) {
            return ["0" => []];
        } else {
            return $this->StarFound;
        }
    }
}