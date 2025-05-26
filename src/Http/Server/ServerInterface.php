<?php

declare(strict_types=1);

namespace Slon\Http\Server;

use Slon\Http\Protocol\ServerMessageInterface;

interface ServerInterface
{
    public function sendMessage(ServerMessageInterface $message): void;
}
