<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Printers;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Contracts\TablePrinter;

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
