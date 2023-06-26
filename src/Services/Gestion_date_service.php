<?php

namespace App\Services;

// Service de gestion des dates
// voir le rapport de stage
class Gestion_date_service
{
    public function get_date($semaine_year)
    {
        // si le slug n'est pas rempli par default : today
        if ($semaine_year == 'today') {
            $weekNumber = date('W'); // Récupère le numéro de la semaine actuelle
            $year = date('Y'); // Récupère l'année en cours
            // on reconstruit ici le slug
            $semaine_year = $weekNumber . '_' . $year;

        } else {
            $weekNumber = (explode('_', $semaine_year))[0];
            $year = (explode('_', $semaine_year))[1];
        }

        // Calcule la date du premier jour de la semaine actuelle
        $firstDayOfWeek = date('Y-m-d', strtotime($year . 'W' . $weekNumber . '1'));

        $currentDay = [];
        // Parcourt les jours de la semaine
        for ($i = 0; $i < 7; $i++) {
            // Récupère la date du jour courant
            $currentDay[] = date('Y-m-d', strtotime($firstDayOfWeek . ' +' . $i . ' day'));

        }

        return ([$semaine_year, [$currentDay, $weekNumber, $year]]);
    }

    // fonction permettant de convertir un mois en ses semaines associées
    public function get_date_weeks_to_month($m_month_year)
    {
        if ($m_month_year == 'today') {
            // $weekNumber = date('W'); // Récupère le numéro de la semaine actuelle

            $month = date('m');
            $year = date('Y'); // Récupère l'année en cours
            // on reconstruit ici le slug

            $m_month_year = 'm_' . $month . '_' . $year;

        } else {
            $month = explode('_', $m_month_year)[1]; // Mois (de 1 à 12)
            $year = explode('_', $m_month_year)[2]; // Année
        }


        // Obtenir la date du premier jour du mois
        $startDate = date('Y-m-d', strtotime("$year-$month-01"));

        // Obtenir la date du dernier jour du mois
        $endDate = date('Y-m-t', strtotime("$year-$month-01"));

        // Obtenir le numéro de semaine du premier jour du mois
        $startWeek = date('W', strtotime($startDate));

        // Obtenir le numéro de semaine du dernier jour du mois
        $endWeek = date('W', strtotime($endDate));

        return [$startDate, $endDate, $startWeek, $endWeek, $month, $year, $m_month_year];
    }
}