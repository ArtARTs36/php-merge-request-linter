<?php

namespace ArtARTs36\MergeRequestLinter\Console\Presentation;

use ArtARTs36\MergeRequestLinter\Contracts\IO\TablePrinter;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

class MetricPrinter
{
    private const HEADERS = ['Metric', 'Value'];

    /**
     * @param Arrayee<int, Metric> $metrics
     */
    public function print(TablePrinter $printer, Arrayee $metrics): void
    {
        $printer->printTable(self::HEADERS, $metrics->mapToArray(static function (Metric $metric) {
            return [$metric->name, $metric->value];
        }));
    }
}
