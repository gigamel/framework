<?php declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Protocol\ClientMessageInterface;

use function array_key_exists;
use function parse_url;
use function strtolower;
use function strpos;
use function strtoupper;
use function str_replace;
use function substr;
use function ucwords;

class ClientMessage implements ClientMessageInterface
{
    /** @var string[] */
    protected array $headers = [];

    /** @var string[] */
    protected array $segments = [];
    
    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            if (0 !== strpos($key, 'HTTP_')) {
                continue;
            }
            
            $key = ucwords(strtolower(substr($key, 5)), '_');
            
            $this->headers[str_replace('_', '-', $key)] = $value;
        }
    }
    
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    public function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
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
    
    public function setSegment(string $name, string $segment): void
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
}
