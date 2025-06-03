<?php

declare(strict_types=1);

namespace Test\Http\Router;

use Psr\Http\Message\UriInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Slon\Http\ClientMessage;
use Slon\Http\Route;
use Slon\Http\Router\RouteInterface;
use Slon\Http\Router\RouteShardInterface;

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
        
        $uriStub = $this->createStub(UriInterface::class);
        
        $uriStub
            ->method('getPath')
            ->willReturn($uri);
        
        $clientMessage
            ->method('getUri')
            ->willReturn($uriStub);

        $routeShard = $route->match($clientMessage);
        $this->assertInstanceOf(RouteShardInterface::class, $routeShard);
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
