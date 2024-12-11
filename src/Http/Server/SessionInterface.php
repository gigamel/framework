<?php

declare(strict_types=1);

namespace Gigamel\Http\Server;

interface SessionInterface
{
    public function start(): bool;

    public function getStatus(): int;

    public function set(string $key, mixed $value): void;

    public function get(string $key): mixed;

    public function exists(string $key): bool;

    public function remove(string $key): void;

    public function abort(): bool;
}
