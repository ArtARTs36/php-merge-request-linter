<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

/**
 * @codeCoverageIgnore
 */
readonly class BotMessage
{
    public function __construct(
        public string $token,
        public string $chatId,
        public string $message,
        public bool   $background,
    ) {
    }
}
