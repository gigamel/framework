<?php

declare(strict_types=1);

namespace Slon\Http\Router;

use Psr\Http\Message\RequestInterface;
use Slon\Http\HttpExceptionInterface;

interface RouterInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function handleClientMessage(RequestInterface $message): RouteShardInterface;

    /**
     * @throws HttpExceptionInterface
     */
    public function generate(string $name, array $segments = []): string;
}
