<?php

declare(strict_types=1);

namespace Slon\Http\Router;

use Slon\Http\HttpExceptionInterface;
use Slon\Http\Protocol\ClientMessageInterface;

interface RouterInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function handleClientMessage(ClientMessageInterface $message): RouteShardInterface;

    /**
     * @throws HttpExceptionInterface
     */
    public function generate(string $name, array $segments = []): string;
}
