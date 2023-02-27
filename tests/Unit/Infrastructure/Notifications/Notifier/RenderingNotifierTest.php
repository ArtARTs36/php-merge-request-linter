<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Message;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\RenderingNotifier;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullRenderer;
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
}
