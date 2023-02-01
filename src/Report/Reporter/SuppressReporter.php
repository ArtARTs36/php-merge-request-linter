<?php

namespace ArtARTs36\MergeRequestLinter\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Reporter;
use ArtARTs36\MergeRequestLinter\Contracts\Report\ReportingFailed;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use Psr\Log\LoggerInterface;

final class SuppressReporter implements Reporter
{
    public function __construct(
        private readonly Reporter $reporter,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function report(LintResult $result, Arrayee $records): void
    {
        try {
            $this->reporter->report($result, $records);
        } catch (ReportingFailed $e) {
            $this->logger->warning(sprintf('[Reporter] Reporting was failed: %s', $e->getMessage()));
        }

        $this->logger->info('[Reporter] report was sent');
    }
}
