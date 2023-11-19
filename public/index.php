<?php

declare(strict_types=1);

use Synthex\Phptherightway\Controllers\GeneratorExampleController;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Controllers\HomeController;
use Synthex\Phptherightway\Controllers\InvoiceController;
use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Core\FileLogger;
use Synthex\Phptherightway\Core\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$logger = FileLogger::create(STORAGE_PATH . '/logs/app.log');

$container = new Container();
$router = new Router($container);

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/examples/generators', [GeneratorExampleController::class, 'index'])
    ->get('/download', [HomeController::class, 'download'])
    ->post('/upload', [HomeController::class, 'upload'])
    ->get('/invoices', [InvoiceController::class, 'index'])
    ->get('/invoices/create', [InvoiceController::class, 'create'])
    ->post('/invoices/create', [InvoiceController::class, 'store']);



(new App(
    container: $container,
    router: $router,
    request: ['uri' => $_SERVER['REQUEST_URI'], 'method' => RequestMethod::from($_SERVER['REQUEST_METHOD'])],
    config: new Config($_ENV),
))->run();
