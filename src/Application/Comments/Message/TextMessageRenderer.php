<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Message;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\MessageRenderer;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;

final class TextMessageRenderer implements MessageRenderer
{
    public function __construct(
        private readonly TextRenderer $renderer,
    ) {
        //
    }

    public function render(MergeRequest $request, LintResult $result, CommentsMessage $config): string
    {
        return $this->renderer->render(
            $config->template,
            [
                'request' => $request,
                'result' => $result,
            ],
        );
    }
}
