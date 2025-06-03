<?php

declare(strict_types=1);

namespace Test\Http\Protocol;

use PHPUnit\Framework\TestCase;
use Slon\Http\Protocol\Headers;

class HeadersTest extends TestCase
{
    public function testConstructor(): void
    {
        $headers = new Headers([
            'Content-Type' => 'text/html',
            'Content-Disposition' => ['form-data', 'name="MessageTitle"'],
        ]);
        
        $this->assertTrue($headers->has('Content-Type'));
        $this->assertTrue($headers->has('Content-Disposition'));
        
        $this->assertEquals(
            $headers->get('Content-Type'),
            ['text/html']
        );
        
        $this->assertEquals(
            $headers->get('Content-Disposition'),
            ['form-data', 'name="MessageTitle"']
        );
        
        $this->assertEquals(
            $headers->getLine('Content-Disposition'),
            'form-data; name="MessageTitle"',
        );
    }
}
