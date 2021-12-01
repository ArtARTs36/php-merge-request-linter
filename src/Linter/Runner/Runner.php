<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\LinterRunner;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
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
                return LintResult::success(new LintNote('Currently is not merge request'), $timer->finish());
            }

            $notes = $linter->run($this->fetcher->fetch($ci));

            return new LintResult($notes->isEmpty(), $notes, $timer->finish());
        } catch (CiNotDetectedException | CiNotSupported $e) {
            return LintResult::fail(new ExceptionNote($e), $timer->finish());
        } catch (InvalidCredentialsException $e) {
            return LintResult::fail(ExceptionNote::withMessage($e->getPrevious(), 'Invalid credentials'), $timer->finish());
        }
    }
}
