<?php

namespace App\Models;

use doctrine;
use App\Entity\Stars;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class GetStar
{
    public $StarId;
    public $doctrine;
    public $idIMDB;

    public function __construct($doctrine, $idIMDB)
    {
        $this->doctrine = $doctrine;
        // reduction de IdIMBD
        $this->idIMDB = $idIMDB;
    }
    public function getstar()
    {
        // recuperation des informations dans le Repository Stars
        $repository = $this->doctrine->getRepository(Stars::class);

        // recupération des infos de la star idIMDB
        $this->StarId = $repository->findBy(['idIMDB' => $this->idIMDB]);

        // Renvoit des resultats de la recherche
        if (empty($this->StarId)) {
            return ["0" => []];
        } else {
            return $this->StarId;
        }
    }
}