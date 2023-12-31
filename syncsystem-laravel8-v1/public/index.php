<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is maintenance / demo mode via the "down" command we
| will require this file so that any prerendered template can be shown
| instead of starting the framework, which could cause an exception.
|
*/

// Local dev environment.
if (file_exists(__DIR__ . '/../storage/framework/maintenance.php')) {
    require __DIR__ . '/../storage/framework/maintenance.php';
}

// Sectorlink.
// if (file_exists(__DIR__ . '/laravel8/storage/framework/maintenance.php')) {
//     require __DIR__ . '/laravel8/storage/framework/maintenance.php';
// }

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

// Local dev environment.
require __DIR__ . '/../vendor/autoload.php';
//require __DIR__.'/../php_modules/vendor/autoload.php';

// Sectorlink.
// require __DIR__ . '/laravel8/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

// Local dev environment.
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Sectorlink.
// $app = require_once __DIR__ . '/laravel8/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

// require __DIR__ . '/../config-application.php'; // SyncSystem customized configuration.

$response = tap($kernel->handle(
    $request = Request::capture()
))->send();

$kernel->terminate($request, $response);
