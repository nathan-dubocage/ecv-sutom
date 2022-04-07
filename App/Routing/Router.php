<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Controller;
use App\Controller\Error404;
use App\Controller\Game;

class Router
{
    private array $routes = [
        '/' => Game::class,
        '/404' => Error404::class,
    ];

    private string $path;

    public function __construct()
    {
        $this->path = $_SERVER['PATH_INFO'] ?? '/';
    }

    public function getController(): void
    {
        $controllerClass = $this->routes[$this->path] ?? $this->routes['/404'];
        $controller = new $controllerClass();

        if (!$controller instanceof Controller) {
            throw new \LogicException("controller $controllerClass should implement ".Controller::class);
        }

        $controller->render();
    }
}
