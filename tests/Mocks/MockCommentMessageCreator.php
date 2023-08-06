<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentMessageCreator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class MockCommentMessageCreator implements CommentMessageCreator
{
    public function __construct(
        private readonly ?string $message,
    ) {
        //
    }

    public function create(MergeRequest $request, LintResult $result, CommentsConfig $config): ?string
    {
        return $this->message;
    }
}
