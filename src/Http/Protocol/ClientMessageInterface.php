<?php declare(strict_types=1);

namespace Gigamel\Http\Protocol;

interface ClientMessageInterface
{
    public function getMethod(): string;
    
    public function getPath(): string;
    
    public function getHeaders(): array;
    
    public function getHeader(string $key): ?string;
    
    public function hasHeader(string $key): bool;
    
    public function setSegment(string $name, string $segment): void;
        
    public function getSegment(string $name): string|int|float|null;
    
    public function hasSegment(string $name): bool;
}
