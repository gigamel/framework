<?php declare(strict_types=1);

namespace Gigamel\Http;

use Gigamel\Http\Protocol\ServerMessageInterface;
use Gigamel\Http\Protocol\ServerMessage\Code;
use RuntimeException;

class Exception extends RuntimeException
{
    public function __construct(
        string $message = '',
        int $code = Code::INTERNAL_SERVER_ERROR,
        ?Exception $e = null
    ) {
        if (!in_array($code, Code::ALLOWED, true)) {
            $code = Code::UNKNOWN_ERROR;
        }
        
        if (empty($message)) {
            $message = Code::TEXT[$code] ?? $message;
        }
        
        parent::__construct($message, $code, $e);
    }
}
