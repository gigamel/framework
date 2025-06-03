<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    public function __construct(string $uri)
    {
        $chunks = \parse_url($uri);
    }
    
    public function getScheme(): string
    {
        return '';
    }
    
    public function getAuthority(): string
    {
        return '';
    }
    
    public function getUserInfo(): string
    {
        return '';
    }
    
    public function getHost(): string
    {
        return '';
    }
    
    public function getPort(): ?int
    {
        return 80;
    }
    
    public function getPath(): string
    {
        return '';
    }
    
    public function getQuery(): string
    {
        return '';
    }
    
    public function getFragment(): string
    {
        return '';
    }
    
    public function withScheme(string $scheme): UriInterface
    {
        return $this;
    }
    
    public function withUserInfo(string $user, ?string $password = null): UriInterface
    {
        return $this;
    }
    
    public function withHost(string $host): UriInterface
    {
        return $this;
    }
    
    public function withPort(?int $port): UriInterface
    {
        return $this;
    }
    
    public function withPath(string $path): UriInterface
    {
        return $this;
    }
    
    public function withQuery(string $query): UriInterface
    {
        return $this;
    }
    
    public function withFragment(string $fragment): UriInterface
    {
        return $this;
    }
    
    public function __toString(): string
    {
        return '';
    }
}
