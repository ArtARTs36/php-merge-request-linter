<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

class MessageCreator
{
    public function __construct(
        private readonly TextRenderer $renderer,
    ) {
        //
    }

    /**
     * @param Map<string, mixed> $data
     */
    public function create(string $template, Map $data): Message
    {
        return new Message(
            $this->renderer->render($template, $data),
            uniqid(),
        );
    }
}
