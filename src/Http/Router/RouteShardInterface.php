<?php

declare(strict_types=1);

namespace Gigamel\Http\Router;

interface RouteShardInterface
{
    public function getHandler(): string;

    public function getSegments(): array;
}
