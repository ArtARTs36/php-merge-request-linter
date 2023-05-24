<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessengerNotifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullRenderer;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\QueueMessenger;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RenderingNotifierTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessengerNotifier::notify
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessengerNotifier::__construct
     */
    public function testNotifyOnMessengerNotFound(): void
    {
        $notifier = new MessengerNotifier(new ArrayMap([]), LocalClock::utc());

        self::expectException(MessengerNotFoundException::class);

        $notifier->notify(
            new Channel(ChannelType::TelegramBot, new ArrayMap([]), TimePeriod::day()),
            new Message('', ''),
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessengerNotifier::notify
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessengerNotifier::__construct
     * @dataProvider providerForTestNotify
     */
    public function testNotify(Channel $channel, string $message, array $queue): void
    {
        $messenger = new QueueMessenger();
        $notifier = new MessengerNotifier(
            new ArrayMap([ChannelType::TelegramBot->value => $messenger]),
            LocalClock::utc(),
        );

        $notifier->notify($channel, new Message($message, '123'));

        self::assertEquals($queue, $messenger->getQueue());
    }
}
