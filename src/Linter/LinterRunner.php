<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Request\RequestFetcher;
use ArtARTs36\MergeRequestLinter\Support\Timer;
use OndraM\CiDetector\CiDetectorInterface;
use OndraM\CiDetector\Exception\CiNotDetectedException;

class LinterRunner
{
    public function __construct(
        protected CiDetectorInterface $ciDetector,
        protected RequestFetcher $fetcher,
    ) {
        //
    }

    public function run(Linter $linter): LintResult
    {
        $timer = Timer::start();

        try {
            $ci = $this->ciDetector->detect();

            if ($ci->isPullRequest()->no()) {
                return LintResult::withoutErrors(LintResult::STATE_CURRENT_NOT_MERGE_REQUEST, $timer->finish());
            }

            $errors = $linter->run($this->fetcher->fetch($ci));

            return new LintResult(
                $errors->isEmpty() ? LintResult::STATE_OK : LintResult::STATE_ERRORS,
                $errors,
                $timer->finish()
            );
        } catch (CiNotDetectedException) {
            return LintResult::withoutErrors(LintResult::STATE_CI_NOT_DETECTED, $timer->finish());
        }
    }
}
