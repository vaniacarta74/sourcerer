<?php

namespace vaniacarta74\Sourcerer\web;

use vaniacarta74\Sourcerer\Router;
use vaniacarta74\Sourcerer\Error;
use vaniacarta74\Sourcerer\Tools;
use vaniacarta74\Sourcerer\Sanitizer;

require __DIR__ . '/../vendor/autoload.php';

try {
    $resource = Tools::convertUrl('file', new Sanitizer());

    $router = new Router($resource);
    $route = $router->getRoute();

    header('Location: http://' . SITPIT_HOST . ROOT . $route);
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
