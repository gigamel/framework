<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

interface RouteResultInterface
{
    public function getHandler(): string;

    public function getSegments(): array;
}
