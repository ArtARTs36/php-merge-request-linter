<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\NotificationsMapper;
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
    public function testMap(array $data, string $exception): void
    {
        $mapper = new NotificationsMapper([]);

        self::expectExceptionMessage($exception);

        $mapper->map($data);
    }
}
