<?php

declare(strict_types=1);

namespace Slon\Http\Router;

use Psr\Http\Message\RequestInterface;

interface RouteInterface
{
    public function getName(): string;

    public function getRule(): string;

    public function getHandler(): string;

    /**
     * @return string[]
     */
    public function getTokens(): array;

    /**
     * @return string[]
     */
    public function getMethods(): array;

    public function match(RequestInterface $message): ?RouteShardInterface;

    public function generate(array $segments = []): string;
}
