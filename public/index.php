<?php

// Hata raporlamasını aç
error_reporting(E_ALL);
ini_set('display_errors', '1');

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Composer autoloader'ı yükle
require __DIR__.'/../vendor/autoload.php';

// Laravel uygulamasını başlat
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
