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

    public function run(Linter $linter): LintErrors
    {
        try {
            $ci = $this->ciDetector->detect();

            if ($ci->isPullRequest()->no()) {
                return new LintErrors([]);
            }

            return $linter->run($this->fetcher->fetch($ci));
        } catch (\Throwable | CiNotDetectedException) {
            return new LintErrors([]);
        }
    }
}
