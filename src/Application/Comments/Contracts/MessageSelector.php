<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for message selectors.
 */
interface MessageSelector
{
    /**
     * Select message from config.
     */
    public function select(MergeRequest $request, CommentsConfig $config, LintResult $result): ?CommentsMessage;
}
