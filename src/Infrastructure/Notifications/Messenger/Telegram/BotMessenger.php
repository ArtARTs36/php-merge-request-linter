<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\NotificationSendException;

class BotMessenger implements Messenger
{
    public function __construct(
        private readonly Bot $bot,
    ) {
        //
    }

    public function send(Channel $channel, string $message): void
    {
        $chatId = $channel->params->get('chat_id');

        if (! is_string($chatId)) {
            throw new NotificationSendException('Telegram Chat ID undefined');
        }

        $token = $channel->params->get('bot_token');

        if (! is_string($token)) {
            throw new NotificationSendException('Telegram Token undefined');
        }

        $this->bot->sendMessage(new BotMessage(
            $token,
            $chatId,
            $message,
        ));
    }
}
