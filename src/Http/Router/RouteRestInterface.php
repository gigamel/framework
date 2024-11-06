<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

interface RouteRestInterface
{
    public function getHandler(): string;

    public function getSegments(): array;
}
