<?php declare(strict_types=1);

namespace Test\Http\Router;

use Gigamel\Http\Route;
use Gigamel\Http\Router\RouteInterface;
use Gigamel\Http\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RoutesCollectionTest extends TestCase
{
    public function testGetRoute(): void
    {
        $routesCollection = new RoutesCollection();

        $routesCollection->add(
            new Route(
                'general',
                '/some/page(/{page})?/more/{id}',
                'Handler'
            )
        );

        $route = $routesCollection->get('general');

        $this->assertInstanceOf(RouteInterface::class, $route);

        $this->assertEquals($route->getName(), 'general');
        $this->assertEquals($route->getRule(), '/some/page(/{page})?/more/{id}');
        $this->assertEquals($route->getHandler(), 'Handler');
    }
}