<?php

declare(strict_types=1);

namespace Slon\Http\Protocol\Stream;

use Psr\Http\Message\StreamInterface;

class StandartStream implements StreamInterface
{
    public function __toString(): string
    {
        return '';
    }
    
    public function close(): void
    {
        // Todo
    }
    
    public function detach()
    {
        // Todo
    }
    
    public function getSize(): ?int
    {
        return 0;
    }
    
    public function tell(): int
    {
         return 0;
    }
    
    public function eof(): bool
    {
        return false;
    }
    
    public function isSeekable(): bool
    {
        return true;
    }
    
    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        
    }
    
    public function rewind(): void
    {
        
    }
    
    public function isWritable(): bool
    {
        return false;
    }
    
    public function write(string $string): int
    {
        return 0;
    }
    
    public function isReadable(): bool
    {
        return false;
    }
    
    public function read(int $length): string
    {
        return '';
    }
    
    public function getContents(): string
    {
        return '';
    }
    
    public function getMetadata(?string $key = null)
    {
        return null;
    }
}
