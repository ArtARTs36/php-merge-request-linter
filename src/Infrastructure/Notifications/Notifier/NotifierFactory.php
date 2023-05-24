<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Messenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\BotMessenger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\HttpBot;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class NotifierFactory
{
    public function __construct(
        private readonly Client $client,
        private readonly ClockInterface $clock,
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
        //
    }

    public function create(): Notifier
    {
        return new LoggableNotifier($this->logger, new RenderingNotifier(
            TwigRenderer::create(),
            $this->createMessengers(),
            $this->clock,
        ));
    }

    /**
     * @return Map<string, Messenger>
     */
    private function createMessengers(): Map
    {
        /** @var Map<string, Messenger> $messengers */
        $messengers = new ArrayMap([
            ChannelType::TelegramBot->value => new BotMessenger(new HttpBot($this->client)),
        ]);

        return $messengers;
    }
}
