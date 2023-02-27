<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

enum ChannelType: string
{
    case TelegramBot = 'telegram_bot';
}
