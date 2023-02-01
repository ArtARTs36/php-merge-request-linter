<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Report;

use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

/**
 * Interface for reporting.
 */
interface Reporter
{
    /**
     * Report lint result.
     * @param Arrayee<int, Record> $records
     * @throws ReportingFailed
     */
    public function report(LintResult $result, Arrayee $records): void;
}
