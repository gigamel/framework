<?php

declare(strict_types=1);

namespace Slon\DI\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends Exception implements
    NotFoundExceptionInterface {}
