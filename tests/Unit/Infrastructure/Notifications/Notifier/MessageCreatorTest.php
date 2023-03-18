<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Notifier;

use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MessageCreatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator::__construct
     */
    public function testCreate(): void
    {
        $creator = new MessageCreator();

        $message = $creator->create('test-template', new ArrayMap($data = ['k' => 'v']));

        self::assertEquals('test-template', $message->template);
        self::assertEquals($data, $message->data->toArray());
        self::assertNotEmpty($message->id);
    }
}
