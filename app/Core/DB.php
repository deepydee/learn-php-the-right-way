<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * @mixin Connection
 */
class DB
{
    private Connection $conn;
    public function __construct(array $config)
    {
        $this->conn = DriverManager::getConnection(Config::getInstance($_ENV)->db ?? []);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->conn, $name], $arguments);
    }
}
