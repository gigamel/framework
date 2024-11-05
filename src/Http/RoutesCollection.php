<?php declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Router\RoutesCollectionInterface;
use Gigamel\Http\Router\RouteInterface;

class RoutesCollection implements RoutesCollectionInterface
{
    /** @var RouteInterface[] */
    protected array $collection = [];

    public function add(RouteInterface ...$route): void
    {
        $this->collection = [...$this->collection, ...$route];
    }

    public function get(string $name): ?RouteInterface
    {
        foreach ($this->getCollection() as $route) {
            if ($name === $route->getName()) {
                return $route;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
