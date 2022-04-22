<?php

namespace vaniacarta74\Sourcerer\tests\providers;

require __DIR__ . '/../../vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

switch ($method) {
    case 'GET':
        $report = [
            'method' => 'GET',
            'params' => filter_input_array(INPUT_GET)
        ];
        break;
    case 'POST':
        if (filter_input(INPUT_GET, 'json')) {
            $params = @file_get_contents('php://input');
            $arrPost = json_decode($params, true);
        } else {
            $arrPost = filter_input_array(INPUT_POST);
        }
        $report = [
            'method' => 'POST',
            'params' => $arrPost
        ];
        break;
    case 'PUT':
        $report = [
            'method' => 'PUT',
            'params' => filter_input_array(INPUT_GET)
        ];
        break;
    case 'PATCH':
        $report = [
            'method' => 'PATCH',
            'params' => filter_input_array(INPUT_GET)
        ];
        break;
    case 'DELETE':
        $report = [
            'method' => 'DELETE',
            'params' => filter_input_array(INPUT_GET)
        ];
        break;
}
$response = [
    'ok' => true,
    'response' => $report
];
http_response_code(200);
echo json_encode($response);
