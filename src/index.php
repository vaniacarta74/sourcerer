<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Router;

require __DIR__ . '/../vendor/autoload.php';

try {
    $file = filter_input(INPUT_GET, 'file');
    $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    
    if ($file) {        
        $taditional = 'src/index.php?file=' . $file;        
        $restful = 'api/' . $file . '/?';
        $url = str_replace($taditional, $restful, $uri);
    } else {    
        $url = $uri;
    }
    
    $path = strtok($url, '?');
    
    $router = new Router($path); 
    $route = $router->getFile();
    
    header('Location: http://' . SITPIT_HOST . $route);
    
} catch (\Exception $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'cli');
    exit();
}
