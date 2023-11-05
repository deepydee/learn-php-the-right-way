<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

/**
 * @mixin \PDO
 */
class DB
{
    private \PDO $pdo;
    public function __construct(array $config)
    {
        $defaultOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $dsn = "{$config['connection']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

            $this->pdo = new \PDO(
                dsn: $dsn,
                username: $config['user'],
                password: $config['password'],
                options: $config['options'] ?? $defaultOptions,
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
