<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;

class MessageCreator
{
    public function __construct(
        private readonly TextRenderer $renderer,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $data
     * @throws TextRenderingFailedException
     */
    public function create(string $template, array $data): Message
    {
        return new Message(
            $this->renderer->render($template, $data),
            uniqid(),
        );
    }
}
