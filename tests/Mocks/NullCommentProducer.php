<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentProducer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class NullCommentProducer implements CommentProducer
{
    public function produce(MergeRequest $request, LintResult $result, CommentsConfig $config): void
    {
        //
    }
}
