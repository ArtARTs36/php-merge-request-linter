<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;

class MessageConditions
{
    public function __construct(
        public readonly LintResult $result,
    ) {
    }
}
