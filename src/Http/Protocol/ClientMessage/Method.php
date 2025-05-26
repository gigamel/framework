<?php

declare(strict_types=1);

namespace Slon\Http\Protocol\ClientMessage;

final class Method
{
    public const string CONNECT = 'CONNECT';
    public const string DELETE = 'DELETE';
    public const string GET = 'GET';
    public const string HEAD = 'HEAD';
    public const string OPTIONS = 'OPTIONS';
    public const string PATCH = 'PATCH';
    public const string POST = 'POST';
    public const string PUT = 'PUT';
    public const string TRACE = 'TRACE';

    public const array ALLOWED = [
        self::CONNECT,
        self::DELETE,
        self::GET,
        self::HEAD,
        self::OPTIONS,
        self::PATCH,
        self::POST,
        self::PUT,
        self::TRACE,
    ];
}
