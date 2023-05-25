<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * The event is created at the moment when the linter has completed its work.
 * @codeCoverageIgnore
 */
class LintFinishedEvent
{
    public const NAME = 'lint_finished';

    public function __construct(
        public readonly MergeRequest $request,
        public readonly LintResult $result,
    ) {
        //
    }
}
