<?php

declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Protocol\ClientMessageInterface;
use Gigamel\Http\Protocol\ClientMessage\Method;
use Gigamel\Http\Protocol\Header;
use JsonException;

use function array_key_exists;
use function file_get_contents;
use function json_decode;
use function parse_url;
use function strtolower;
use function strpos;
use function strtoupper;
use function str_contains;
use function str_replace;
use function substr;
use function ucwords;

class ClientMessage implements ClientMessageInterface
{
    /** @var string[] */
    protected array $headers = [];

    /** @var string[] */
    protected array $segments = [];

    protected Uri $uri;

    protected array $bodyParams = [];
    
    public function __construct()
    {
        $this->parseHeaders();
        $this->uri = new Uri($_SERVER['REQUEST_URI']);
        $this->parseBodyParams();
    }
    
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    public function getPath(): string
    {
        return $this->uri->getPath();
    }
    
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    public function getHeader(string $key): ?string
    {
        return $this->headers[$key] ?? null;
    }
    
    public function hasHeader(string $key): bool
    {
        return array_key_exists($key, $this->headers);
    }
    
    public function setSegment(string $name, string|int|float $segment): void
    {
        $this->segments[$name] = match (true) {
            ctype_digit($segment) => (int) $segment,
            is_numeric($segment) => (float) $segment,
            default => $segment,
        };
    }
    
    public function getSegment(string $name): string|int|float|null
    {
        return $this->segments[$name] ?? null;
    }
    
    public function hasSegment(string $name): bool
    {
        return array_key_exists($name, $this->segments);
    }

    public function isMethod(string $method): bool
    {
        return $this->getMethod() === trim(strtoupper($method));
    }

    public function getUriParam(string $name, mixed $default = null): mixed
    {
        return $_GET[$name] ?? $default;
    }

    public function getBodyParam(string $name, mixed $default = null): mixed
    {
        return $this->bodyParams[$name] ?? $default;
    }

    protected function parseHeaders(): void
    {
        foreach ($_SERVER as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $this->headers[$this->normalizeHeader(substr($key, 5))] = $value;
            }
        }
    }

    protected function normalizeHeader(string $key): string
    {
        return str_replace('_', '-', ucwords(strtolower($key), '_'));
    }

    protected function parseBodyParams(): void
    {
        if (!$this->hasHeader(Header::CONTENT_TYPE)) {
            $this->bodyParams = $_POST;
            return;
        }

        $contentType = $this->getHeader(Header::CONTENT_TYPE);

        if (str_contains($contentType, 'application/json')) {
            try {
                $this->bodyParams = json_decode(file_get_contents('php://input') ?: '', true, 512, JSON_THROW_ON_ERROR);
                return;
            } catch (JsonException) {
                // nothing to do
            }
        }

        if ($this->isMethod(Method::POST)) {
            $this->bodyParams = $_POST;
        }
    }
}
