<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;
use Gigamel\Http\Protocol\ServerMessage\Code;
use Exception;

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
    public function handleClientMessage(ClientMessageInterface $message): RouteInterface
    {
        foreach ($this->collection->getCollection() as $route) {
            if (!in_array($message->getMethod(), $route->getHttpMethods(), true)) {
                continue;
            }

            if ($route->match($message)) {
                return $route;
            }
        }

        throw new Exception('Route not found');
    }

    public function generate(string $name, array $segments = []): string
    {
        $route = $this->collection->get($name);
        if ($route) {
            return $route->generate($segments);
        }
        throw new Exception('Route not found');
    }
}
