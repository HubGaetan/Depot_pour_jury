<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Services\Gestion_date_service;

class GestionDateServiceTest extends TestCase
{
    public function testGetDate()
    {
        // On Créé une instance du service gestion date
        $gestionDateService = new Gestion_date_service();

        // On va tester la méthode get_date() qui prend comme parametre $semaine_year

        // 1. On teste le résultat sur la semaine 25 qui est la semaine actuelle
        // Où on sait que à cette semaine correspond la semaine du lundi 19 juin au 25 juin 2023

        $semaineYear = '25_2023';
        // on calcule le résultat grace au service
        $result = $gestionDateService->get_date($semaineYear);

        // On effectue une assertion pour comparer les résultats trouvés et ceux connus
        $this->assertEquals(['25_2023', [['2023-06-19', '2023-06-20', '2023-06-21', '2023-06-22', '2023-06-23', '2023-06-24', '2023-06-25'], '25', '2023']], $result);

        // 2. Dans l'application, le parametre $semaine_year peut prendre la valeur "today" qui correspond a la semaine actuelle
        // on vérifie donc que les résultats sont bien les memes
        // a noter qu'a partir du 26 juin cette assertion sera fausse
        $semaineYear = 'today';
        // on le calcule grace au service
        $result_today = $gestionDateService->get_date($semaineYear);

        // On vérifie l'assertion que today est bien la semaine 25
        $this->assertEquals($result_today, $result);

        // 3. On effectue une nouvelle assertion pour la transition de février d'une année bisextile du lundi 26 février au 3 mars 2024
        $semaineYear = '09_2024';
        $result = $gestionDateService->get_date($semaineYear);
        $this->assertEquals(['09_2024', [['2024-02-26', '2024-02-27', '2024-02-28', '2024-02-29', '2024-03-01', '2024-03-02', '2024-03-03'], '09', '2024']], $result);

    }
}