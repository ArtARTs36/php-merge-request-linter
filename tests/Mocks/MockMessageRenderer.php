<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\MessageRenderer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class MockMessageRenderer implements MessageRenderer
{
    public function __construct(
        private readonly string $rendered,
    ) {
    }

    public function render(MergeRequest $request, LintResult $result, CommentsMessage $config): string
    {
        return $this->rendered;
    }
}
