<?php

declare(strict_types=1);

use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Controllers\HomeController;
use Synthex\Phptherightway\Controllers\InvoiceController;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;
use Synthex\Phptherightway\Core\View;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

try {
    $router = new Router();

    $router
        ->get('/', [HomeController::class, 'index'])
        ->get('/download', [HomeController::class, 'download'])
        ->post('/upload', [HomeController::class, 'upload'])
        ->get('/invoices', [InvoiceController::class, 'index'])
        ->get('/invoices/create', [InvoiceController::class, 'create'])
        ->post('/invoices/create', [InvoiceController::class, 'store']);

    echo $router->resolve($_SERVER['REQUEST_URI'], RequestMethod::from($_SERVER['REQUEST_METHOD']));
} catch(RouteNotFoundException $e) {
    http_response_code(404);

    echo View::make('error/404');
}

