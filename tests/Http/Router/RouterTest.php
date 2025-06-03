<?php declare(strict_types=1);

namespace Test\Http\Router;

use Psr\Http\Message\UriInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Slon\Http\ClientMessage;
use Slon\Http\Route;
use Slon\Http\Router;
use Slon\Http\Router\RouterInterface;
use Slon\Http\Router\RouteShardInterface;
use Slon\Http\RoutesCollection;

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
        
        $uriStub = $this->createStub(UriInterface::class);
        
        $uriStub
            ->method('getPath')
            ->willReturn($path);

        $clientMessage
            ->method('getUri')
            ->willReturn($uriStub);

        $clientMessage
            ->method('getMethod')
            ->willReturn('GET');

        $router = $this->makeRouter($rule);

        $routeShard = $router->handleClientMessage($clientMessage);

        $this->assertInstanceOf(RouteShardInterface::class, $routeShard);
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
