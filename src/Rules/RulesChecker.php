<?php declare(strict_types=1);

namespace Gigamel\Rules;

class RulesChecker implements CheckerInterface
{
    /**
     * @throws Exception
     */
    public function check(RulesInterface $rules): void
    {
        $rules = $rules->getRules();
        if (!$rules) {
            return;
        }
        
        $arguments = $this->getArguments();
        foreach ($rules as $rule) {
            $rule->check(...array_values($arguments));
        }
    }
}
