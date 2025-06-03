<?php

declare(strict_types=1);

namespace Test\Http\Protocol;

use PHPUnit\Framework\TestCase;
use Slon\Http\Protocol\ClientMessage;

class ClientMessageTest extends TestCase
{
    public function testConstructor(): void
    {
        $clientMessage = new ClientMessage(
            'http://localhost:8000',
            'POST',
        );
        
        $this->assertEquals($clientMessage->getMethod(), 'POST');
    }
}
