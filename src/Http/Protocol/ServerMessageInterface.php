<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

interface ServerMessageInterface
{
    public function getBody(): string;
    
    public function addHeader(string $header, string $value): void;

    /**
     * @param string[] $headers
     */
    public function addHeaders(array $headers = []): void;
    
    /**
     * @return string[]
     */
    public function getHeaders(): array;
    
    public function getStatusCode(): int;
}
