<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Rule\Dumper\RuleInfo;
use Symfony\Component\Console\Style\StyleInterface;

class RulePrinter
{
    private const HEADERS = ['#', 'Definition', 'Class'];

    /**
     * @param iterable<RuleInfo> $rules
     */
    public function print(StyleInterface $output, iterable $rules): void
    {
        $i = 0;
        $rows = [];

        foreach ($rules as $rule) {
            $rows[] = [
                ++$i,
                $rule->definition,
                $rule->class,
            ];
        }

        $output->table(self::HEADERS, $rows);
    }
}
