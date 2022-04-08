<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\api\Router;
use vaniacarta74\Sourcerer\api\Error;

require __DIR__ . '/../vendor/autoload.php';

try {
    $file = filter_input(INPUT_GET, 'file');
    $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    
    if ($file) {        
        $taditional = 'index.php?file=' . $file;        
        $restful = 'api/' . $file . '/?';
        $url = str_replace($taditional, $restful, $uri);
    } else {    
        $url = $uri;
    }
    
    $resource = strtok($url, '?');
    
    $router = new Router($resource); 
    $route = $router->getRoute();  
    
    header('Location: http://' . SITPIT_HOST . $route);
    
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
