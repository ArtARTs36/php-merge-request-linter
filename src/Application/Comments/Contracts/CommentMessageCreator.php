<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for CommentMessageCreator.
 */
interface CommentMessageCreator
{
    /**
     * Create Comment
     */
    public function create(MergeRequest $request, LintResult $result, CommentsConfig $config): ?string;
}
