<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 */
class Config
{
    private static ?self $instance = null;
    protected array $config = [];

    protected function __construct(array $env) {
        $this->config = [
            'db' => [
                'connection' => $env['DB_CONNECTION'] ?? 'mysql',
                'host' => $env['DB_HOST'],
                'port' => $env['DB_PORT'],
                'dbname' => $env['DB_NAME'],
                'user' => $env['DB_USER'],
                'password' => $env['DB_PASS'],
                'driver' => $env['DB_DRIVER'] ?? 'pdo_mysql',
            ],
            'mailer' => [
                'dsn' => $_ENV['MAILER_DSN'] ?? ''
            ],
        ];
    }

    public static function getInstance(array $env): self
    {
        if (self::$instance === null) {
            self::$instance = new self($env);
        }

        return self::$instance;
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}
