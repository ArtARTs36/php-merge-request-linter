<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class CommentFormatter
{
    public function __construct(
        private readonly TextRenderer $renderer,
    ) {
        //
    }

    public function format(MergeRequest $request, LintResult $result, CommentsConfig $config): string
    {
        return $this->renderer->render(
            $config->template,
            new ArrayMap([
                'request' => $request,
                'result' => $result,
            ]),
        );
    }
}
