<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

/**
 * @property-read ?array $db
 * @property-read ?array $mailer
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env) {
        $this->config = [
            'db' => [
                'connection' => $env['DB_CONNECTION'] ?? 'mysql',
                'host' => $env['DB_HOST'],
                'port' => $env['DB_PORT'],
                'dbname' => $env['DB_NAME'],
                'user' => $env['DB_USER'],
                'password' => $env['DB_PASS'],
            ],
            'mailer' => [
                'dsn' => $_ENV['MAILER_DSN'] ?? ''
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
