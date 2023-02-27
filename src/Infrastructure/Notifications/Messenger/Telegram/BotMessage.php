<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

/**
 * @codeCoverageIgnore
 */
class BotMessage
{
    public function __construct(
        public readonly string $token,
        public readonly string $chatId,
        public readonly string $message,
    ) {
        //
    }
}
