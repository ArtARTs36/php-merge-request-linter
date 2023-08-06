<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\MessageSelector;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class MockMessageSelector implements MessageSelector
{
    public function __construct(
        private readonly ?CommentsMessage $commentsMessage,
    ) {
    }

    public function select(MergeRequest $request, CommentsConfig $config, LintResult $result): ?CommentsMessage
    {
        return $this->commentsMessage;
    }
}
