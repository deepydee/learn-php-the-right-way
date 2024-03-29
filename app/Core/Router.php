<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Attributes\Route;
use Synthex\Phptherightway\Core\Container;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
    }

    public function registerRoutesFromControllerAttributes(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $this->register($route->method, $route->path, [$controller, $method->getName()]);
                }
            }
        }
    }

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

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }
}
