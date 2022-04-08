<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\api\Router;
use vaniacarta74\Sourcerer\api\Error;
use vaniacarta74\Sourcerer\api\Utility;

require __DIR__ . '/../vendor/autoload.php';

try {    
    $resource = Utility::convertUrl('file');
    
    $router = new Router($resource); 
    $route = $router->getRoute();  
    
    header('Location: http://' . SITPIT_HOST . $route);
    
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
