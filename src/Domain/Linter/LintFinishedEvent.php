<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * @codeCoverageIgnore
 */
class LintFinishedEvent
{
    public const NAME = 'lint_finished';

    public function __construct(
        public readonly MergeRequest $request,
    ) {
        //
    }
}
