<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use ArtARTs36\MergeRequestLinter\Application\Rule\Dumper\RuleInfo;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\TablePrinter;

class RuleInfoPrinter
{
    private const HEADERS = ['#', 'Name', 'Definition', 'Critical'];

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
                $rule->name,
                $rule->definition,
                $rule->critical ? 'true' : 'false',
            ];
        }

        $printer->printTable(self::HEADERS, $rows);
    }
}
