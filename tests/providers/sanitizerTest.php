<?php

namespace vaniacarta74\Sourcerer\tests\providers;

use vaniacarta74\Sourcerer\api\Sanitizer;

require __DIR__ . '/../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$var_name = $_GET['var_name'] ?? null;
$filter = $_GET['filter'] ?? null;
$options = $_GET['options'] ?? null;

$report = Sanitizer::inputGet($var_name, $filter, $options);

$response = [
    'ok' => true,
    'response' => $report
];    
http_response_code(200);
echo json_encode($response);
