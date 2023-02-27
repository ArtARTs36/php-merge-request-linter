<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;

class TelegramBotMessenger implements Messenger
{
    public function __construct(
        private readonly TelegramBot $bot,
    ) {
        //
    }

    public function send(Channel $channel, string $message): void
    {
        $chatId = $channel->params->get('chat_id');
        $token = $channel->params->get('bot_token');

        $this->bot->sendMessage(new TelegramMessage(
            $token,
            $chatId,
            $message,
        ));
    }
}
