<?php declare(strict_types=1);

namespace Gigamel\Http\Server;

use Gigamel\Http\Protocol\ServerMessageInterface;

interface ServerInterface
{
    public function sendMessage(ServerMessageInterface $message): void;
}
