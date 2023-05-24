<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use Psr\Clock\ClockInterface;

class RenderingNotifier implements Notifier
{
    /**
     * @param Map<string, Messenger> $messengers
     */
    public function __construct(
        private readonly TextRenderer $renderer,
        private readonly Map $messengers,
        private readonly ClockInterface $clock,
    ) {
        //
    }

    public function notify(Channel $channel, Message $message): void
    {
        $messenger = $this->messengers->get($channel->type->value);

        if ($messenger === null) {
            throw MessengerNotFoundException::create($channel->type);
        }

        $text = $this->renderer->render($message->template, $message->data);

        $messenger->send($channel, $text, $channel->sound->input($this->clock->now()));
    }
}
