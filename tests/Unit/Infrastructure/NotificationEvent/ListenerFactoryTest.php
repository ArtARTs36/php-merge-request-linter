<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ConditionListener;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\NotifyListener;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ListenerFactoryTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [
                new NotificationEventMessage('name', new Channel(ChannelType::TelegramBot, new ArrayMap([])), ''),
                NotifyListener::class,
            ],
            [
                new NotificationEventMessage('name', new Channel(ChannelType::TelegramBot, new ArrayMap([])), '', ['field' => ['equals' => 1]]),
                ConditionListener::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory::__construct
     * @dataProvider providerForTestCreate
     */
    public function testCreate(NotificationEventMessage $message, string $expected): void
    {
        $factory = new ListenerFactory(new class () implements Notifier {
            public function notify(Channel $channel, Message $message): void
            {
                //
            }
        }, new MockOperatorResolver(), new MessageCreator());

        $listener = $factory->create($message);

        self::assertInstanceOf($expected, $listener);
    }
}
