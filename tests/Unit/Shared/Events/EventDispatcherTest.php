<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class EventDispatcherTest extends TestCase
{
    public function providerForTestDispatch(): array
    {
        return [
            [
                TestEvent::class,
                new TestEvent(),
                1,
            ],
            [
                'test',
                new TestEventWithName(),
                1,
            ],
            [
                TestEvent::class,
                new TestEventWithName(),
                0,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher::dispatch
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher::listen
     * @dataProvider providerForTestDispatch
     */
    public function testDispatch(string $listenEventName, object $event, int $expectedCalls): void
    {
        $dispatcher = new EventDispatcher();

        $calls = 0;

        $listener = function () use (&$calls) {
            $calls++;
        };

        $dispatcher->listen($listenEventName, $listener);

        $dispatcher->dispatch($event);

        self::assertEquals($expectedCalls, $calls);
    }
}

class TestEvent
{
    //
}

class TestEventWithName
{
    public const NAME = 'test';
}
