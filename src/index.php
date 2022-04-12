<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\api\Router;
use vaniacarta74\Sourcerer\api\Error;
use vaniacarta74\Sourcerer\api\Tools;
use vaniacarta74\Sourcerer\api\Sanitizer;

require __DIR__ . '/../vendor/autoload.php';

try {    
    $resource = Tools::convertUrl('file', new Sanitizer());
    
    $router = new Router($resource); 
    $route = $router->getRoute();  
    
    header('Location: http://' . SITPIT_HOST . $route);
    
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
