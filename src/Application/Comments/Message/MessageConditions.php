<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * @codeCoverageIgnore
 */
readonly class MessageConditions
{
    public function __construct(
        public MergeRequest $request,
        public LintResult   $result,
    ) {
    }
}
