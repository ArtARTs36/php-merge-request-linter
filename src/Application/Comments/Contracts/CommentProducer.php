<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\SendCommentException;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for CommentProducer.
 */
interface CommentProducer
{
    /**
     * Produce Comment
     * @throws SendCommentException
     */
    public function produce(MergeRequest $request, LintResult $result, CommentsConfig $config): void;
}
