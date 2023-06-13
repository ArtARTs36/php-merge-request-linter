<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

class MessageCreator
{
    public function __construct(
        private readonly MessageSelector $selector,
        private readonly MessageFormatter $formatter,
    ) {
        //
    }

    public function create(MergeRequest $request, LintResult $result, CommentsConfig $config): ?string
    {
        $message = $this->selector->select($config, $result);

        if ($message === null) {
            return null;
        }

        return $this->formatter->format($request, $result, $message);
    }
}
