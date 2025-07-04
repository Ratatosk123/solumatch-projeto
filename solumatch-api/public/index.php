<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;


// INÍCIO DO CÓDIGO DE DEPURAÇÃO - REMOVER DEPOIS DE RESOLVER O PROBLEMA
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// FIM DO CÓDIGO DE DEPURAÇÃO

// O resto do ficheiro continua como está...
define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
