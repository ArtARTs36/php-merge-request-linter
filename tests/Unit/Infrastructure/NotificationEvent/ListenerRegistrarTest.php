<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerRegistrar;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockEventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockOperatorResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ListenerRegistrarTest extends TestCase
{
    public function providerForTestRegister(): array
    {
        return [
            [
                [
                    'test-event' => [
                        new NotificationEventMessage(
                            'test-event',
                            new Channel(ChannelType::TelegramBot, new ArrayMap([])),
                            'test-template',
                        ),
                    ],
                ],
                1,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerRegistrar::register
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerRegistrar::__construct
     * @dataProvider providerForTestRegister
     */
    public function testRegister(array $notificationsConfig, int $expectedListeners): void
    {
        $registrar = new ListenerRegistrar(
            new NotificationsConfig(
                new ArrayMap([]),
                new ArrayMap($notificationsConfig),
            ),
            new ListenerFactory(new class () implements Notifier {
                public function notify(Channel $channel, Message $message): void
                {
                    //
                }
            }, new MockOperatorResolver(), new MessageCreator()),
        );

        $mockDispatcher = new MockEventDispatcher();

        $registrar->register($mockDispatcher);

        self::assertCount($expectedListeners, $mockDispatcher->listeners);
    }
}
