<?php
namespace vaniacarta74\Sourcerer;

use vaniacarta74\Sourcerer\Error;

require __DIR__ . '/../vendor/autoload.php';

try {
    if (filter_var(ENAS_SERVER_WEB_HOST, FILTER_VALIDATE_IP)) {
        header('Location: http://' . ENAS_SERVER_WEB_HOST . ROUTES['telecontrollo_classico']['params'][SITE]);       
    } else {
        throw new \Exception('Host Telecontrollo Classico non definito');
    }    
} catch (\Throwable $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'cli');
    exit();
}
