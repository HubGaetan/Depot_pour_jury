<?php

use doctrine;
use App\Entity\DateStars;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * Summary of GetDateBDD
 * permet de récupérer les données dans la DateBDD la liste des stars pour un jour donné
 */
class GetDateBDD
{
    public $DateFound;
    public $doctrine;
    public $date;

    /**
     * Summary of __construct
     * @param mixed $doctrine
     * @param mixed $date
     */
    public function __construct($doctrine, $date)
    {
        $this->doctrine = $doctrine;
        $this->date = $date;
    }
    public function getdatebdd()
    {
        $repository = $this->doctrine->getRepository(DateStars::class);
        $DateFound = $repository->findBy(['MD' => $this->date]);

        if (empty($DateFound)) {
            return ["0" => []];
        } else {
            return $DateFound;
        }
    }
}