<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

/**
 * Interface for Telegram Bot.
 */
interface Bot
{
    /**
     * Send message to telegram channel via bot.
     */
    public function sendMessage(BotMessage $message): void;
}
