<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\Exception;
use Gigamel\Http\Protocol\ClientMessageInterface;

interface RouterInterface
{
    /**
     * @throws Exception
     */
    public function handleClientMessage(ClientMessageInterface $message): RouteInterface;

    /**
     * @throws Exception
     */
    public function generate(string $name, array $segments = []): string;
}
