<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

interface ClientMessageInterface
{
    public function getMethod(): string;
    
    public function getPath(): string;
    
    public function getHeaders(): array;
    
    public function getHeader(string $key): ?string;
    
    public function hasHeader(string $key): bool;
    
    public function setSegment(string $name, string|int|float $segment): void;
        
    public function getSegment(string $name): string|int|float|null;
    
    public function hasSegment(string $name): bool;

    public function isMethod(string $method): bool;

    public function getUriParam(string $name, mixed $default = null): mixed;

    public function getBodyParam(string $name, mixed $default = null): mixed;

    public function getFormParam(string $name, mixed $default = null): mixed;
}
