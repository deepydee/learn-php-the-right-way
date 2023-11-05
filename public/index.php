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

    $email = 'vito11@hooligan11.com';
    $name = 'Vitalii Hooligan';
    $isActive = 1;
    $createdAt = date('Y-m-d H:i:s', strtotime('07/11/2021 9:00PM'));

    $query = 'INSERT INTO users (email, full_name, is_active, created_at)
              VALUES (:email, :name, :is_active, :created_at)';

    $stmt = $db->prepare($query);

    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindParam(':is_active', $isActive, PDO::PARAM_BOOL);
    $stmt->bindValue(':created_at', $createdAt);

    $isActive = 0;

    $stmt->execute();

    $id = $db->lastInsertId();

    $user = $db->query('SELECT * FROM users WHERE id = ' . $id)->fetch();
    var_dump($user);

    // foreach ($db->query('SELECT * FROM users WHERE id = ' . $id) as $user) {
    //     echo '<pre>';
    //     var_dump($user);
    //     echo '</pre>';
    // }

    $router = new Router();

    $router
        ->get('/', [HomeController::class, 'index'])
        ->get('/download', [HomeController::class, 'download'])
        ->post('/upload', [HomeController::class, 'upload'])
        ->get('/invoices', [InvoiceController::class, 'index'])
        ->get('/invoices/create', [InvoiceController::class, 'create'])
        ->post('/invoices/create', [InvoiceController::class, 'store']);

    echo $router->resolve($_SERVER['REQUEST_URI'], RequestMethod::from($_SERVER['REQUEST_METHOD']));
} catch (RouteNotFoundException $e) {
    http_response_code(404);

    echo View::make('error/404');
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

