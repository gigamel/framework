<?php declare(strict_types=1);

namespace Gigamel\Http\Server;

interface SessionInterface
{
    /**
     * @throws SessionException
     */
    public function start(array $options = []): bool;

    public function getStatus(): int;

    /**
     * @throws SessionException
     */
    public function set(string $key, mixed $value): void;

    public function get(string $key): mixed;

    public function abort(): bool;
}
