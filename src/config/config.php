<?php
namespace vaniacarta74\Sourcerer\config;

require_once('php_Sourcerer.inc.php');

$now = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
define('START', $now->format('Y-m-d H:i:s.u'));

define('DEBUG_LEVEL', 2);
define('ERROR_LOG', __DIR__ . '/../../log/error.log');

$strJson = @file_get_contents(__DIR__ . '/json/routes.json');
$routes = json_decode($strJson, true);
define('ROUTES', $routes);
