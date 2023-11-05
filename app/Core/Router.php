<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function register(RequestMethod $method, string $route, callable|array $action): self
    {
        $this->routes[$method->value][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register(
            RequestMethod::GET,
            $route,
            $action,
        );
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register(
            RequestMethod::POST,
            $route,
            $action,
        );
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, RequestMethod $method)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$method->value][$route] ?? null;

        if (! $action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
