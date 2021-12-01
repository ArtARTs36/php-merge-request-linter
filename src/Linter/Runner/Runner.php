<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\LinterRunner;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Request\RequestFetcher;
use ArtARTs36\MergeRequestLinter\Support\Timer;
use OndraM\CiDetector\CiDetectorInterface;
use OndraM\CiDetector\Exception\CiNotDetectedException;

class Runner implements LinterRunner
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
        } catch (CiNotSupported) {
            return LintResult::withoutErrors(LintResult::STATE_CI_NOT_SUPPORTED, $timer->finish());
        } catch (InvalidCredentialsException) {
            return LintResult::withoutErrors(LintResult::STATE_INVALID_CREDENTIALS, $timer->finish());
        }
    }
}
