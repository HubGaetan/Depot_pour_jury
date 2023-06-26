<?php

namespace App\Controllers;

use Database\DBConnection;

abstract class Controller
{

    protected $db;

    /**
     * Summary of __construct
     * @param DBConnection $db
     */
    public function __construct(DBConnection $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
    }

    /**
     * Summary of view
     * view redirige vers la page à afficher
     * en corrigeant la route
     * @param string $path
     * @param array|null $params
     * @return void
     */
    protected function view(string $path, array $params = null)
    {
        // demarrage du cache
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        //injections des parametres
        require VIEWS . $path . '.php';
        // recuperation des infos
        $content = ob_get_clean();
        //affichage 
        require VIEWS . 'layout.php';
    }

    /**
     * Summary of getDB
     * @return DBConnection
     */
    protected function getDB()
    {
        return $this->db;
    }

    /**
     * isAdmin permet de vérifier si l'utilisateur est <admin>
     * sinon il le renvoit automatiquement vers la page de login 
     * @return bool
     */
    protected function isAdmin()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
            return true;
        } else {
            return header('Location:' . HREF_ROOT . 'login');
        }
    }
}