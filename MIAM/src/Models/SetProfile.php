<?php

namespace App\Models;

class SetProfile
{


    function set_profile_user($user, $doctrine)
    {


        // irrigation de l'objet user avec les parametres rentrés dans le profil

        $user->setFormation($_POST['formation'] ?? '');
        $user->setStatus($_POST['regime'] ?? 'Ext');
        $user->setAdressePostale($_POST['adresse_postale'] ?? []);
        $user->setVegan($_POST['vegan'] ?? "0");
        $user->setPorc($_POST['porc'] ?? "1");
        $user->setAllergies($_POST['allergies'] ?? []);

        // enregistrement en BDD
        $manager = $doctrine->getManager();


        // on l'enregistre dans la BDD
        $manager->persist($user);
        $manager->flush();
    }
}