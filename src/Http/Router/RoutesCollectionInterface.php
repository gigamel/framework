<?php

declare(strict_types=1);

namespace Slon\Http\Router;

interface RoutesCollectionInterface
{
    public function add(RouteInterface ...$route): void;

    public function get(string $name): ?RouteInterface;

    /**
     * @return RouteInterface[]
     */
    public function getCollection(): array;
}
