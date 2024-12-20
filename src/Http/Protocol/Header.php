<?php

declare(strict_types=1);

namespace Gigamel\Http\Protocol;

use function strtolower;
use function str_replace;
use function ucwords;

final class Header
{
    public const string AUTHORIZATION = 'Authorization';
    public const string CACHE_CONTROL = 'Cache-Control';
    public const string CONTENT_LENGTH = 'Content-Length';
    public const string CONTENT_TYPE = 'Content-Type';
    public const string HOST = 'Host';
    public const string LOCATION = 'Location';
    public const string REFERER = 'Referer';

    public static function normalize(string $header): string
    {
        return str_replace('_', '-', ucwords(strtolower($header), '_'));
    }
}
