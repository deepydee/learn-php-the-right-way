<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Synthex\Phptherightway\Core\Router;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Exceptions\RouteNotFoundException;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    public function test_that_it_registers_a_route(): void
    {
        $this->router->register(RequestMethod::GET, '/users', ['Users', 'index']);

        $expected = [
            'GET' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_that_it_registers_a_get_route(): void
    {
        $this->router->get('/users', ['Users', 'index']);

        $expected = [
            'GET' => [
                '/users' => ['Users', 'index'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_that_it_registers_a_post_route(): void
    {
        $this->router->post('/users', ['Users', 'store']);

        $expected = [
            'POST' => [
                '/users' => ['Users', 'store'],
            ],
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    public function test_there_are_no_routes_wnen_router_is_created(): void
    {
        $this->assertEmpty((new Router())->routes());
    }

    /**
     * @dataProvider \Tests\DataProviders\RouterDataProvider::routeNotFoundCases
     */
    public function test_it_throws_route_not_found_exception(
        string $requestUri,
        RequestMethod $requestMethod,
    ): void {
        $users = new class() {
            public function delete(): bool
            {
                return true;
            }
        };

        $this->router->post('/users', [$users::class, 'store']);
        $this->router->get('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public function test_it_resolves_route_from_a_closuse(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertEquals(
            [1, 2, 3],
            $this->router->resolve('/users', RequestMethod::GET)
        );
    }

    public function test_it_resolves_route(): void
    {
        $users = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        $this->router->get('/users', [$users::class, 'index']);

        $this->assertSame(
            [1, 2, 3],
            $this->router->resolve('/users', RequestMethod::GET)
        );
    }
}
