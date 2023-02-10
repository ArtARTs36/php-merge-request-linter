<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Support\Time\Timer;

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
            $notes = $linter->run($this->requestFetcher->fetch());

            return new LintResult($notes->isEmpty(), $notes, $timer->finish());
        } catch (CurrentlyNotMergeRequestException) {
            return LintResult::success(new LintNote('Currently is not merge request'), $timer->finish());
        } catch (CiNotSupported|InvalidCredentialsException $e) {
            return LintResult::fail(new ExceptionNote($e), $timer->finish());
        }
    }
}
