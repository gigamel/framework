<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\HttpException;
use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;
use Gigamel\Http\Protocol\ServerMessage\Code;

use function in_array;

class Router implements RouterInterface
{
    public function __construct(
        protected CollectionInterface $collection
    ) {
    }

    /**
     * @throws inheritDoc
     */
    public function handleClientMessage(ClientMessageInterface $message): RouteRestInterface
    {
        foreach ($this->collection->getCollection() as $route) {
            if (!in_array($message->getMethod(), $route->getMethods(), true)) {
                continue;
            }

            if ($routeRest = $route->match($message)) {
                return $routeRest;
            }
        }

        throw new HttpException('Route not found', 404);
    }

    public function generate(string $name, array $segments = []): string
    {
        $route = $this->collection->get($name);
        if ($route) {
            return $route->generate($segments);
        }
        throw new HttpException('Route not found', 404);
    }
}
