<?php declare(strict_types=1);

namespace Test\Http\Router;

use Gigamel\Http\ClientMessage;
use Gigamel\Http\Route;
use Gigamel\Http\Router\RouteInterface;
use Gigamel\Http\Router\RouteRestInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public static function matchDataProvider(): array
    {
        return [
            'fullPath' => [
                'uri' => '/some/page/10/more/100',
            ],
            'shortPath' => [
                'uri' => '/some/page/more/100',
            ],
        ];
    }

    public function testGenerate(): void
    {
        $route = $this->makeRoute();

        $this->assertEquals(
            $route->generate(['page' => 10, 'id' => 100]),
            '/some/page/10/more/100'
        );

        $this->assertEquals(
            $route->generate(['id' => 100]),
            '/some/page/more/100'
        );
    }

    #[DataProvider('matchDataProvider')]
    public function testMatch(string $uri): void
    {
        $route = $this->makeRoute();

        $clientMessage = $this->createStub(ClientMessage::class);
        $clientMessage
            ->method('getPath')
            ->willReturn($uri);

        $routeRest = $route->match($clientMessage);
        $this->assertInstanceOf(RouteRestInterface::class, $routeRest);
    }

    private function makeRoute(): RouteInterface
    {
        return new Route(
            'general',
            '/some/page(/{page})?/more/{id}',
            'Handler',
            [
                'page' => '\d+',
                'id' => '\d+'
            ]
        );
    }
}
