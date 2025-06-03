<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    protected ParsedUrl $parsedUrl;

    public function __construct(string $uri)
    {
        \assert(\filter_var($uri, \FILTER_VALIDATE_URL));
        $this->parsedUrl = new ParsedUrl(...\parse_url($uri));
    }
    
    public function getScheme(): string
    {
        return $this->parsedUrl->scheme;
    }
    
    public function getAuthority(): string
    {
        return $this->parsedUrl->authority;
    }
    
    public function getUserInfo(): string
    {
        return $this->parsedUrl->userInfo;
    }
    
    public function getHost(): string
    {
        return $this->parsedUrl->host;
    }
    
    public function getPort(): ?int
    {
        return $this->parsedUrl->port;
    }
    
    public function getPath(): string
    {
        return $this->parsedUrl->path;
    }
    
    public function getQuery(): string
    {
        return $this->parsedUrl->query;
    }
    
    public function getFragment(): string
    {
        return $this->parsedUrl->fragment;
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
        return (string) $this->parsedUrl;
    }
}
