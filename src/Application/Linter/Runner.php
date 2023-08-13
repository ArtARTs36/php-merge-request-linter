<?php

namespace ArtARTs36\MergeRequestLinter\Application\Linter;

use ArtARTs36\MergeRequestLinter\Domain\CI\GettingMergeRequestException;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Note\ExceptionNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequestFetcher;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Domain\Linter\Linter;
use ArtARTs36\Str\Facade\Str;

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
            $message = 'Currently is not merge request';

            if (($exMessage = $e->getMessage()) && Str::isNotEmpty($exMessage)) {
                $message .= ': ' . $exMessage;
            }

            return LintResult::successWithNote(new LintNote($message), $timer->finish());
        } catch (\Throwable $e) {
            return LintResult::fail(new ExceptionNote($e), $timer->finish());
        }
    }
}
