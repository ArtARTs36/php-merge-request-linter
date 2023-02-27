<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Exceptions;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MessengerNotFoundExceptionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions\MessengerNotFoundException::create
     */
    public function testCreate(): void
    {
        $e = MessengerNotFoundException::create(ChannelType::TelegramBot);

        self::assertEquals(
            'Messenger for channel with type "telegram_bot" not found',
            $e->getMessage(),
        );
    }
}
