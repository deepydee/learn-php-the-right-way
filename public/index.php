<?php

declare(strict_types=1);

use Synthex\Phptherightway\Controllers\DoctrineController;
use Synthex\Phptherightway\Controllers\UserController;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Controllers\HomeController;
use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Core\FileLogger;
use Synthex\Phptherightway\Core\Container;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$logger = FileLogger::create(STORAGE_PATH . '/logs/app.log');

$container = new Container();
$router = new Router($container);

$router->registerRoutesFromControllerAttributes([
    HomeController::class,
    UserController::class,
    DoctrineController::class,
]);

(new App(
    container: $container,
    router: $router,
    request: ['uri' => $_SERVER['REQUEST_URI'], 'method' => RequestMethod::from($_SERVER['REQUEST_METHOD'])],
))->boot()->run();
