<?php

declare(strict_types=1);

use App\Routing\Router;

spl_autoload_register(function ($fqcn): void {
    $path = str_replace('\\', '/', $fqcn);
    require_once __DIR__.'/../'.$path.'.php';
});

$router = new Router();
$router->getController();
