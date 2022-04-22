<?php

namespace vaniacarta74\Sourcerer\web;

use vaniacarta74\Sourcerer\Router;
use vaniacarta74\Sourcerer\Error;
use vaniacarta74\Sourcerer\Tools;
use vaniacarta74\Sourcerer\Sanitizer;
use vaniacarta74\Sourcerer\SessionManager;

require __DIR__ . '/../vendor/autoload.php';

try {
    $resource = Tools::convertUrl('file', new Sanitizer());

    $router = new Router($resource);
    $route = $router->getRoute();

    $session = new SessionManager(SESSION_PATH, SESSION_LIFETIME);
    $_SESSION['pippo'] = 'pluto';
    $_SESSION['topolino'] = 'paperino';
    session_write_close();
    $test = $_SESSION;

    $session2 = new SessionManager();
    $_SESSION['pippo2'] = 'pluto';
    $_SESSION['topolino2'] = 'paperino';
    session_write_close();

    header('Location: http://' . SITPIT_HOST . ROOT . $route);
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
