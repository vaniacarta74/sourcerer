<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Router;

require __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    $menu = filter_input(INPUT_GET, 'menu');
    $type = filter_input(INPUT_GET, 'type');
    $uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
    $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    
    if ($menu && $type) {        
        $taditional = 'src/index.php?menu=' . $menu . '&type=' . $type;        
        $restful = 'api/' . $menu . '/' . $type . '/?';
        $url = str_replace($taditional, $restful, $uri);
        $method = 'GET';
    } else {    
        $url = $uri;
    }
    
    $path = strtok($url, '?');
    
    $router = new Router($path, $method);
    $host = $router->getHost();
    $dbName = $router->getDb();
    $resource = $router->getResource();
    $queryParams = $router->getQueryParams();
    $urlParams = $router->getUrlParams();

    $validator = new Validator($queryParams, $urlParams);
    $purgedQuery = $validator->getPurgedQuery();
    $validParams = $validator->getValidParams();
    
    $results = DbWrapper::dateTime($host, $dbName, $purgedQuery, $validParams);
    
    $responder = new Responder($resource, $results);
    $response = $responder->getResponse();
    
    http_response_code(200);
    echo json_encode($response);
} catch (\Exception $e) {
    http_response_code(400);
    Error::errorHandler($e, 1, 'cli');
    Error::noticeHandler($e, 2, 'json');
    exit();
}
