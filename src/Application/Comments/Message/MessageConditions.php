<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * @codeCoverageIgnore
 */
class MessageConditions
{
    public function __construct(
        public readonly MergeRequest $request,
        public readonly LintResult $result,
    ) {
    }
}
