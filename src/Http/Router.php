<?php

declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\HttpException;
use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;
use Gigamel\Http\Protocol\ServerMessage\Code;
use Gigamel\Http\Router\RouterInterface;
use Gigamel\Http\Router\RoutesCollectionInterface;
use Gigamel\Http\Router\RouteShardInterface;

use function in_array;

class Router implements RouterInterface
{
    public function __construct(
        protected RoutesCollectionInterface $collection
    ) {
    }

    /**
     * @throws inheritDoc
     */
    public function handleClientMessage(ClientMessageInterface $message): RouteShardInterface
    {
        foreach ($this->collection->getCollection() as $route) {
            if (!in_array($message->getMethod(), $route->getMethods(), true)) {
                continue;
            }

            if ($routeShard = $route->match($message)) {
                return $routeShard;
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
