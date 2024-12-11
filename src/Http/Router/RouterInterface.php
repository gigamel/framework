<?php

declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\HttpExceptionInterface;
use Gigamel\Http\Protocol\ClientMessageInterface;

interface RouterInterface
{
    /**
     * @throws HttpExceptionInterface
     */
    public function handleClientMessage(ClientMessageInterface $message): RouteRestInterface;

    /**
     * @throws HttpExceptionInterface
     */
    public function generate(string $name, array $segments = []): string;
}
