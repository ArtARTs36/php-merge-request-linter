<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Domain\Linter\Linter;

final class Runner implements LinterRunner
{
    public function __construct(
        private readonly MergeRequestFetcher $requestFetcher,
    ) {
        //
    }

    public function run(Linter $linter): LintResult
    {
        $timer = Timer::start();

        try {
            return $linter->run($this->requestFetcher->fetch());
        } catch (CurrentlyNotMergeRequestException $e) {
            return LintResult::successWithNote(new LintNote($e->getMessage()), $timer->finish());
        } catch (MergeRequestLinterException $e) {
            return LintResult::fail((new LintNote($e->getMessage()))->withSeverity(NoteSeverity::Fatal), $timer->finish());
        } catch (\Throwable $e) {
            return LintResult::fail(new ExceptionNote($e), $timer->finish());
        }
    }
}
