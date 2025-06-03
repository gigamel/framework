<?php

declare(strict_types=1);

namespace Slon\Http;

use Psr\Http\Message\RequestInterface;
use Slon\Http\HttpException;
use Slon\Http\Router\RouterInterface;
use Slon\Http\Router\RoutesCollectionInterface;
use Slon\Http\Router\RouteShardInterface;

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
    public function handleClientMessage(RequestInterface $message): RouteShardInterface
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
