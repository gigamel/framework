<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use function array_filter;

class RouteRest implements RouteRestInterface
{
    public function __construct(
        protected readonly string $handler,
        array $segments = []
    ) {
        $this->segments = array_filter($segments, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getSegments(): array
    {
        return $this->segments;
    }
}