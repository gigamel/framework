<?php

declare(strict_types=1);

namespace Gigamel\Http;

use function parse_url;

final class Uri
{
    private string $path;

    private string $query;

    public function __construct(string $uri)
    {
        $parsed = parse_url($uri);

        $this->path = $parsed['path'] ?? '/';
        $this->query = $parsed['query'] ?? '';
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
