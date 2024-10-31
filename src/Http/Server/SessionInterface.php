<?php declare(strict_types=1);

namespace Gigamel\Http\Server;

interface SessionInterface
{
    public function start(array $options = []): bool;
}
