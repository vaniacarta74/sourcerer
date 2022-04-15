<?php

namespace vaniacarta74\Sourcerer\web;

use vaniacarta74\Sourcerer\Error;
use vaniacarta74\Sourcerer\Validator;

require __DIR__ . '/../vendor/autoload.php';

try {
    $ip = Validator::validateIPv4(SITPIT_CLASSIC_HOST);
    $host_name = Validator::validateHostName(SITPIT_CLASSIC_HOST);

    if ($ip) {
        header('Location: http://' . $ip . ROUTES['multisettoriale_25k']['params'][SITE]);
    } else {
        header('Location: http://' . $host_name . ROUTES['telecontrollo_classico']['params'][SITE]);
    }
} catch (\Throwable $e) {
    Error::errorHandler($e, DEBUG_LEVEL, 'html');
    exit();
}
