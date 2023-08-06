<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullRenderer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MessageCreatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator::__construct
     */
    public function testCreate(): void
    {
        $creator = new MessageCreator(new NullRenderer());

        $message = $creator->create('test-template', []);

        self::assertEquals('test-template', $message->text);
        self::assertNotEmpty($message->id);
    }
}
