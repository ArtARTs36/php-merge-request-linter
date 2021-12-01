<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

use ArtARTs36\MergeRequestLinter\Request\RequestFetcher;
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
        $timer = $this->createTimer();

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

    protected function createTimer(): object
    {
        return new class {
            protected float $started;

            public function __construct()
            {
                $this->started = microtime(true);
            }

            public function finish(): float
            {
                return microtime(true) - $this->started;
            }
        };
    }
}
