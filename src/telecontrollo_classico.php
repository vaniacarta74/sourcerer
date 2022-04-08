<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\api\Error;
use vaniacarta74\Sourcerer\api\Validator;

require __DIR__ . '/../vendor/autoload.php';

try {
    $ip = Validator::validateIPv4(ENAS_SERVER_WEB_HOST);
    $host_name = Validator::validateHostName(ENAS_SERVER_WEB_HOST);
    
    if ($ip) {
        header('Location: http://' . $ip . ROUTES['telecontrollo_classico']['params'][SITE]);       
    } elseif ($host_name) {
        header('Location: http://' . $host_name . ROUTES['telecontrollo_classico']['params'][SITE]);       
    } else {
        throw new \Exception('Host Telecontrollo Classico non definito');
    }    
} catch (\Throwable $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
