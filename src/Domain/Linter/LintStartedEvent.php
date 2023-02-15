<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Event for lint starting.
 * @codeCoverageIgnore
 */
class LintStartedEvent
{
    public function __construct(
        public readonly MergeRequest $request,
    ) {
        //
    }
}
