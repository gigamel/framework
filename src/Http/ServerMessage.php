<?php

declare(strict_types=1);

namespace Slon\Http;

use Slon\Http\Protocol\ServerMessageInterface;
use Slon\Http\Protocol\ServerMessage\Code;

class ServerMessage implements ServerMessageInterface
{
    /** @var string[] */
    protected array $headers = [];
    
    /**
     * @param string[] $headers
     */
    public function __construct(
        protected string $body = '',
        protected int $statusCode = Code::OK,
        array $headers = []
    ) {
        $this->addHeaders($headers);
    }
    
    public function getBody(): string
    {
        return $this->body;
    }
    
    public function addHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    /**
     * @inheritDoc
     */
    public function addHeaders(array $headers = []): void
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
