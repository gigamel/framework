<?php

declare(strict_types=1);

namespace Slon\Rules;

interface CheckerInterface
{
    /**
     * @throws Exception
     */
    public function check(RulesInterface $rules): void
}
