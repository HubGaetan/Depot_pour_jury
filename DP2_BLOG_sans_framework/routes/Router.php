<?php

namespace Router;

use App\Exceptions\NotFoundException;

class Router
{

    public $url;
    public $routes = [];

    /**
     * Summary of __construct
     * recupere l'url et la "trim" si nécessaire
     * @param mixed $url
     */
    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    /**
     * Summary of get
     * @param string $path
     * @param string $action
     * @return void
     */
    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    /**
     * Summary of post
     * @param string $path
     * @param string $action
     * @return void
     */
    public function post(string $path, string $action)
    {
        $this->routes['POST'][] = new Route($path, $action);
    }

    /**
     * Summary of run
     * @throws NotFoundException
     * @return mixed
     */
    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }

        throw new NotFoundException("La page demandée est introuvable.");
    }
}