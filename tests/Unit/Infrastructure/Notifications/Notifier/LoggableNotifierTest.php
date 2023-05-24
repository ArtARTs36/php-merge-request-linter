<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\LoggableNotifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\CounterLogger;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class LoggableNotifierTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\LoggableNotifier::notify
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\LoggableNotifier::__construct
     */
    public function testNotify(): void
    {
        $logger = new CounterLogger();

        $subNotifier = new class () implements Notifier {
            public function notify(Channel $channel, Message $message): void
            {
                //
            }
        };

        $notifier = new LoggableNotifier($logger, $subNotifier);

        $notifier->notify(
            new Channel(ChannelType::TelegramBot, new ArrayMap([]), TimePeriod::day()),
            new Message('', ''),
        );

        self::assertEquals(2, $logger->getMessagesCount());
    }
}
