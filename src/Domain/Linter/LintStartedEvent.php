<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @codeCoverageIgnore
 */
#[Description('The event is created at the moment when the linter has just started.')]
readonly class LintStartedEvent
{
    public const NAME = 'lint_started';

    public function __construct(
        public MergeRequest $request,
    ) {
        //
    }
}
