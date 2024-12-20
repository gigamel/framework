<?php

declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Router\RouteShardInterface;

use function array_filter;

class RouteShard implements RouteShardInterface
{
    protected array $segments;

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
