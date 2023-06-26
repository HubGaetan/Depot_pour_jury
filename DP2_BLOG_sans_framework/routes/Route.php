<?php

namespace Router;

use Database\DBConnection;

class Route {

    public $path;
    public $action;
    public $matches;

    /**
     * Summary of __construct
     * @param mixed $path
     * @param mixed $action
     */
    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');        
        $this->action = $action;
    }

    /**
     * Summary of matches
     * Matches renvoie true si le l'url est une route valable
     * false si elle n'est pas valable
     * @param string $url
     * @return bool
     */
    public function matches(string $url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";

        if (preg_match($pathToMatch, $url, $matches)) {
            $this->matches = $matches;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Summary of execute
     * @return mixed
     */
    public function execute()
    {
        $params = explode('@', $this->action);
        $controller = new $params[0](new DBConnection(DB_NAME, DB_HOST, DB_USER, DB_PWD));
        $method = $params[1];

        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    }
}
