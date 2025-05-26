<?php

declare(strict_types=1);

namespace Gigamel\Http;

use RuntimeException;
use Slon\Http\Protocol\ServerMessage\Code;

class HttpException extends RuntimeException implements HttpExceptionInterface
{
    public function __construct(
        string $message = '',
        int $code = Code::INTERNAL_SERVER_ERROR,
        protected array $headers = [],
        ?Exception $e = null
    ) {
        if (empty($message)) {
            $message = Code::TEXT[$code] ?? $message;
        }
        
        parent::__construct($message, $code, $e);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
