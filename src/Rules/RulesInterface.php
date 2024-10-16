<?php declare(strict_types=1);

namespace Gigamel\Rules;

interface RulesInterface
{
    public function getRules(): array;
    
    public function getArguments(): array;
}
