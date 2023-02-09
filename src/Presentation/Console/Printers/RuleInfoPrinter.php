<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleInfo;
use ArtARTs36\MergeRequestLinter\Contracts\IO\TablePrinter;

class RuleInfoPrinter
{
    private const HEADERS = ['#', 'Definition', 'Class'];

    /**
     * @param iterable<RuleInfo> $rules
     */
    public function print(TablePrinter $printer, iterable $rules): void
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

        $printer->printTable(self::HEADERS, $rows);
    }
}
