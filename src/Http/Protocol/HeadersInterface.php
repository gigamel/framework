<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

interface HeadersInterface
{
    public function all(): array;
    
    public function has(string $name): bool;
    
    public function get(string $name): array;
    
    public function add(string $name, string|array $value): void;
}
