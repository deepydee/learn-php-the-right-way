<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Core\Config;
use Synthex\Phptherightway\Core\DB;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;

    public function __construct(
        protected Router $router,
        protected array $request,
        protected Config $config,
    ) {
        static::$db = new DB($config->db ?? []);
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
