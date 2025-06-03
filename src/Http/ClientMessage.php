<?php

declare(strict_types=1);

namespace Slon\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Slon\Http\Protocol\ClientMessage\Method;
use Slon\Http\Protocol\Headers;
use Slon\Http\Protocol\Stream\StandartStream;
use Slon\Http\Protocol\Uri;
use Slon\Http\Protocol\Version;

class ClientMessage implements RequestInterface
{
    protected UriInterface $uri;

    protected Headers $headers;
    
    protected string $method;

    protected string $protocolVersion;

    public function __construct(
        string $uri,
        string $method,
        array $headers = [],
        string $protocolVersion = Version::HTTP_1_1,
    ) {
        $this->uri = new Uri($uri);
        $this->setMethod($method);
        $this->setProtocolVersion($protocolVersion);
        $this->headers = new Headers($headers);
    }
    
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }
    
    public function withProtocolVersion(string $version): MessageInterface
    {
        if ($version === $this->protocolVersion) {
            return $this;
        }
        
        return (clone $this)->setProtocolVersion($version);
    }
    
    public function getHeaders(): array
    {
        return $this->headers->all();
    }
    
    public function hasHeader(string $name): bool
    {
        return $this->headers->has($name);
    }
    
    public function getHeader(string $name): array
    {
        return $this->headers->get($name);
    }
    
    public function getHeaderLine(string $name): string
    {
        return $this->headers->getLine($name);
    }
    
    public function withHeader(
         string $name,
         $value,
    ): MessageInterface {
        $cloned = clone $this;
        $cloned->headers->set($name, $value);
        return $cloned;
    }
    
    public function withAddedHeader(
        string $name,
        $value,
    ): MessageInterface {
        $cloned = clone $this;
        $cloned->headers->add($name, $value);
        return $cloned;
    }
    
    public function withoutHeader(string $name): MessageInterface
    {
        $cloned = clone $this;
        $cloned->headers->remove($name, $value);
        return $cloned;
    }
    
    public function getBody(): StreamInterface
    {
        return new StandartStream(); // Todo
    }
    
    public function withBody(StreamInterface $body): MessageInterface
    {
        return $this;
    }
    
    public function getRequestTarget(): string
    {
        return '*'; // Todo
    }
    
    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        return $this; // Todo
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function withMethod(string $method): RequestInterface
    {
        return (clone $this)->setMethod($method);
    }
    
    public function getUri(): UriInterface
    {
        return $this->uri;
    }
    
    public function withUri(
        UriInterface $uri,
        bool $preserveHost = false,
    ): RequestInterface {
        return $this;
    }
    
    protected function setMethod(string $method): self
    {
        \assert(\in_array($method, Method::ALLOWED, true));
        $this->method = $method;
        return $this;
    }

    protected function setProtocolVersion(string $version): self
    {
        \assert(\in_array($version, Version::NUMBERS, true));
        $this->protocolVersion = $version;
        return $this;
    }
}
