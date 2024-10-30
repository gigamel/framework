<?php declare(strict_types=1);

namespace Gigamel\Http\Router;

use Gigamel\Http\Protocol\ClientMessageInterface;

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

    public function match(ClientMessageInterface $message): ?RouteRestInterface;

    public function generate(array $segments = []): string;
}
