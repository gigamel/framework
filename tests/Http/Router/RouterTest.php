<?php declare(strict_types=1);

namespace Test\Http\Router;

use Gigamel\Http\ClientMessage;
use Gigamel\Http\Route;
use Gigamel\Http\Router;
use Gigamel\Http\Router\RouterInterface;
use Gigamel\Http\Router\RouteInterface;
use Gigamel\Http\Router\RouteRestInterface;
use Gigamel\Http\RoutesCollection;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public static function handleClientMessageDataProvider(): array
    {
        return [
            'fullPath' => [
                'path' => '/some/page/10/more/100',
            ],
            'shortPath' => [
                'path' => '/some/page/more/100',
            ],
            'hardPath' => [
                'path' => '/some/more/100',
                'rule' => '/some/(page/{page}/)?more/100',
            ],
        ];
    }

    public function testGenerate(): void
    {
        $router = $this->makeRouter();

        $this->assertEquals(
            $router->generate('general', ['page' => 10, 'id' => 100]),
            '/some/page/10/more/100'
        );

        $this->assertEquals(
            $router->generate('general', ['id' => 100]),
            '/some/page/more/100'
        );
    }

    #[DataProvider('handleClientMessageDataProvider')]
    public function testHandleClientMessage(
        string $path,
        ?string $rule = null
    ): void {
        $clientMessage = $this->createStub(ClientMessage::class);

        $clientMessage
            ->method('getPath')
            ->willReturn($path);

        $clientMessage
            ->method('getMethod')
            ->willReturn('GET');

        $router = $this->makeRouter($rule);

        $routeRest = $router->handleClientMessage($clientMessage);

        $this->assertInstanceOf(RouteRestInterface::class, $routeRest);
    }

    private function makeRouter(?string $rule = null): RouterInterface
    {
        $routesCollection = new RoutesCollection();

        $routesCollection->add(
            new Route(
                'general',
                $rule ?? '/some/page(/{page})?/more/{id}',
                'Handler',
                [
                    'page' => '\d+',
                    'id' => '\d+',
                ]
            )
        );

        return new Router($routesCollection);
    }
}
