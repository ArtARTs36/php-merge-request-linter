<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Dumper;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;

class RuleDumper
{
    /**
     * @param iterable<Rule> $rules
     * @return array<RuleInfo>
     */
    public function dump(iterable $rules): array
    {
        $infos = [];

        $this->doDump($rules, $infos);

        return $infos;
    }

    /**
     * @param iterable<Rule> $rules
     * @param array<RuleInfo> $infos
     */
    private function doDump(iterable $rules, array &$infos): void
    {
        foreach ($rules as $rule) {
            if ($rule instanceof RuleDecorator) {
                $this->doDump($rule->getDecoratedRules(), $infos);

                continue;
            }

            $infos[] = new RuleInfo(
                $rule->getDefinition(),
                $rule::class,
            );
        }
    }
}
