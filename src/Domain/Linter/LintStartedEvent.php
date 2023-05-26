<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * The event is created at the moment when the linter has just started.
 * @codeCoverageIgnore
 */
class LintStartedEvent
{
    public const NAME = 'lint_started';

    public function __construct(
        public readonly MergeRequest $request,
    ) {
        //
    }
}
