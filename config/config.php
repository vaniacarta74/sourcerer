<?php

namespace vaniacarta74\Sourcerer\config;

require_once('php_Sourcerer.inc.php');

$now = new \DateTime('NOW', new \DateTimeZone('Europe/Rome'));
define('START', $now->format('Y-m-d H:i:s.u'));

$routesJson = @file_get_contents(__DIR__ . '/json/routes.json');
$routes = json_decode($routesJson, true);
define('ROUTES', $routes);

$systemJson = @file_get_contents(__DIR__ . '/json/system.json');
$system = json_decode($systemJson, true);
define('TIMEOUT', $system['timeout']);
define('DEBUG_LEVEL', $system['debug_level']);
define('ROOT', $system['root']);
define('JOOMLA_ROOT', $system['joomla_root']);
define('ERROR_LOG', __DIR__ . '/../../' . $system['error_log']);

ini_set('memory_limit', $system['memory_limit']);
ini_set('max_execution_time', TIMEOUT);
