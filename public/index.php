<?php

declare(strict_types=1);

use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Controllers\HomeController;
use Synthex\Phptherightway\Controllers\InvoiceController;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

$router
    ->register('/', [HomeController::class, 'index'])
    ->register('/invoices', [InvoiceController::class, 'index'])
    ->register('/invoices/create', [InvoiceController::class, 'create']);

echo $router->resolve($_SERVER['REQUEST_URI']);
