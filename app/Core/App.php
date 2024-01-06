<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Symfony\Component\Mailer\MailerInterface;
use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Core\Container;
use Synthex\Phptherightway\Core\DB;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;
use Synthex\Phptherightway\Interfaces\PaymentGatewayServiceInterface;
use Synthex\Phptherightway\Services\CustomMailer;
use Synthex\Phptherightway\Services\PaymentGatewayService;

class App
{
    private static DB $db;
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {
    }

    public function boot(): static
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->safeLoad();

        $this->config = new Config($_ENV);
        static::$db = new DB($this->config->db ?? []);

        $this->container->set(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);
        $this->container->set(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));

        return $this;
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve(
                $this->request['uri'],
                $this->request['method'],
            );
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
