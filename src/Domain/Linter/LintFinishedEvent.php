<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * The event is created at the moment when the linter has completed its work.
 * @codeCoverageIgnore
 */
readonly class LintFinishedEvent
{
    public const NAME = 'lint_finished';

    public function __construct(
        public MergeRequest $request,
        public LintResult   $result,
    ) {
        //
    }
}
