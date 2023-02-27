<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\TelegramBot;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\TelegramBotMessenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class NotifierFactory
{
    public function __construct(
        private readonly Client $client,
    ) {
        //
    }

    public function create(): Notifier
    {
        return new RenderingNotifier(
            TwigRenderer::create(),
            $this->createMessengers(),
        );
    }

    /**
     * @return Map<string, Messenger>
     */
    private function createMessengers(): Map
    {
        return new ArrayMap([
            ChannelType::TelegramBot->value => new TelegramBotMessenger(new TelegramBot($this->client)),
        ]);
    }
}
