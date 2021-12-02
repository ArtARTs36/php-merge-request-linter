<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\LinterRunner;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Linter\Linter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Support\Timer;

class Runner implements LinterRunner
{
    public function __construct(
        protected CiSystemFactory $systems,
    ) {
        //
    }

    public function run(Linter $linter): LintResult
    {
        $timer = Timer::start();

        try {
            $ci = $this->systems->createCurrently();

            if (! $ci->isMergeRequest()) {
                return LintResult::success(new LintNote('Currently is not merge request'), $timer->finish());
            }

            $notes = $linter->run($ci->getMergeRequest());

            return new LintResult($notes->isEmpty(), $notes, $timer->finish());
        } catch (CiNotSupported $e) {
            return LintResult::fail(new ExceptionNote($e), $timer->finish());
        } catch (InvalidCredentialsException $e) {
            return LintResult::fail(ExceptionNote::withMessage($e->getPrevious(), 'Invalid credentials'), $timer->finish());
        }
    }
}
