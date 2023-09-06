<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommentMessageCreator;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\MessageRenderer;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\MessageSelector;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class MessageCreator implements CommentMessageCreator
{
    public function __construct(
        private readonly MessageSelector $selector,
        private readonly MessageRenderer         $renderer,
    ) {
    }

    public function create(MergeRequest $request, LintResult $result, CommentsConfig $config): ?string
    {
        $message = $this->selector->select($request, $config, $result);

        if ($message === null) {
            return null;
        }

        return $this->renderer->render($request, $result, $message);
    }
}
