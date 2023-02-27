<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullRenderer;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\QueueMessenger;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RenderingNotifierTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier::notify
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier::__construct
     */
    public function testNotifyOnMessengerNotFound(): void
    {
        $notifier = new RenderingNotifier(new NullRenderer(), new ArrayMap([]));

        self::expectException(MessengerNotFoundException::class);

        $notifier->notify(
            new Channel(ChannelType::TelegramBot, new ArrayMap([])),
            new Message('', new ArrayMap([])),
        );
    }

    public function providerForTestNotify(): array
    {
        return [
            [
                'channel' => $ch1 = new Channel(ChannelType::TelegramBot, new ArrayMap([])),
                'message' => 'test-message',
                'queue' => [
                    [$ch1, 'test-message']
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier::notify
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier::__construct
     * @dataProvider providerForTestNotify
     */
    public function testNotify(Channel $channel, string $message, array $queue): void
    {
        $messenger = new QueueMessenger();
        $notifier = new RenderingNotifier(
            new NullRenderer(),
            new ArrayMap([ChannelType::TelegramBot->value => $messenger]),
        );

        $notifier->notify($channel, new Message($message, new ArrayMap([])));

        self::assertEquals($queue, $messenger->getQueue());
    }
}
