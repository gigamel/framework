<?php

declare(strict_types=1);

namespace Slon\Http\Protocol;

final class Version
{
    public const string HTTP_1_0 = '1.0';
    public const string HTTP_1_1 = '1.1';
    public const string HTTP_2 = '2';
    public const string HTTP_3 = '3';
    
    public const array NUMBERS = [
        self::HTTP_1_0,
        self::HTTP_1_1,
        self::HTTP_2,
        self::HTTP_3,
    ];
}
