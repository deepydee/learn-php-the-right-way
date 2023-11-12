<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Core\Container;
use Synthex\Phptherightway\Core\DB;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;
use Synthex\Phptherightway\Services\EmailService;
use Synthex\Phptherightway\Services\InvoiceService;
use Synthex\Phptherightway\Services\PaymentGatewayService;
use Synthex\Phptherightway\Services\SalesTaxService;

class App
{
    private static DB $db;
    public static Container $container;

    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config,
    ) {
        static::$db = new DB($config->db ?? []);
        static::$container = new Container();

        static::$container->set(InvoiceService::class, function(Container $c) {
            return new InvoiceService(
                $c->get(SalesTaxService::class),
                $c->get(PaymentGatewayService::class),
                $c->get(EmailService::class),
            );
        });

        static::$container->set(SalesTaxService::class, fn() => new SalesTaxService());
        static::$container->set(PaymentGatewayService::class, fn() => new PaymentGatewayService());
        static::$container->set(EmailService::class, fn() => new EmailService());
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
