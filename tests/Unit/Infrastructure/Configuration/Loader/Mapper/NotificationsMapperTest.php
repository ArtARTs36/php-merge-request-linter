<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NotificationsMapperTest extends TestCase
{
    public function providerForTestMapOnExceptions(): array
    {
        return [
            [
                [],
                'Config[notifications.channels] must be provided',
            ],
            [
                [
                    'channels' => 1,
                ],
                'Config[notifications.channels] has invalid type. Expected type: array, actual: integer',
            ],
            [
                [
                    'channels' => [],
                ],
                'Config[notifications.on] must be provided',
            ],
            [
                [
                    'channels' => [],
                    'on' => [
                        'super_event' => [
                            [],
                        ],
                    ],
                ],
                'Config[notifications.on.super_event.channel] must be provided',
            ],
            [
                [
                    'channels' => [],
                    'on' => [
                        'super_event' => [
                            'channel' => 1.0,
                        ],
                    ],
                ],
                'Config[notifications.on.super_event.channel] has invalid type. Expected type: string, actual: float',
            ],
            [
                [
                    'channels' => [],
                    'on' => [
                        'super_event' => [
                            'channel' => 'tg_channel',
                        ],
                    ],
                ],
                'Config[notifications.on.super_event.template] must be provided',
            ],
            [
                [
                    'channels' => [],
                    'on' => [
                        'super_event' => [
                            'channel' => 'tg_channel',
                            'template' => 'template',
                        ],
                    ],
                ],
                'Config[notifications.on.super_event.channel] invalid!',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::mapChannels
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::mapNotifications
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::__construct
     * @dataProvider providerForTestMapOnExceptions
     */
    public function testMapOnExceptions(array $data, string $exception): void
    {
        $mapper = new NotificationsMapper([]);

        self::expectExceptionMessage($exception);

        $mapper->map($data);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::mapChannels
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper::mapNotifications
     */
    public function testMap(): void
    {
        $mapper = new NotificationsMapper([]);

        $result = $mapper->map([
            'channels' => [
                'tg_channel' => [
                    'type' => 'telegram_bot',
                ],
            ],
            'on' => [
                'event' => [
                    'channel' => 'tg_channel',
                    'template' => 'test-template',
                ],
            ],
        ]);

        self::assertEquals(
            new NotificationsConfig(
                new ArrayMap([
                    'tg_channel' => $ch1 = new Channel(
                        ChannelType::TelegramBot,
                        new ArrayMap([]),
                        TimePeriod::day(),
                    ),
                ]),
                new ArrayMap([
                    'event' => [
                        new NotificationEventMessage(
                            'event',
                            $ch1,
                            'test-template',
                        ),
                    ],
                ]),
            ),
            $result,
        );
    }
}
