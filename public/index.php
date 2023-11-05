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
    $connection = $_ENV['DB_CONNECTION'];
    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $dbname = $_ENV['DB_NAME'];

    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];

    $dsn = "$connection:host=$host;port=$port;dbname=$dbname";

    $db = new \PDO(
        dsn: $dsn,
        username: $user,
        password: $password,
        options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]
    );

    $email = $_GET['email'];

    // SQL injection http://php.test/?email=foo@bar.com%22+OR+1=1--%22
    $query = 'SELECT * FROM users WHERE email = "' . $email . '"';

    echo $query . '<br>';

    foreach($db->query($query)->fetchAll() as $user) {
        echo '<pre>';
        var_dump($user);
        echo '</pre>';
    }

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
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), $e->getCode());
}

