<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Core\Container;
use Synthex\Phptherightway\Core\DB;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;
use Synthex\Phptherightway\Interfaces\PaymentGatewayServiceInterface;
use Synthex\Phptherightway\Services\PaymentGatewayService;

class App
{
    private static DB $db;

    public function __construct(
        protected Container $container,
        protected Router $router,
        protected array $request,
        protected Config $config,
    ) {
        static::$db = new DB($config->db ?? []);

        $this->container->set(PaymentGatewayServiceInterface::class, PaymentGatewayService::class);
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
