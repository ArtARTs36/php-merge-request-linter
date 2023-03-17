<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Events;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher::subscribe
     */
    public function testSubscribe(): void
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->subscribe($subscriber = new class () implements EventSubscriber {
            public int $calls = 0;

            public function getSubscribedEvents(): array
            {
                return [
                    TestEvent::class => 'handleEvent',
                ];
            }

            public function handleEvent(TestEvent $event): void
            {
                ++$this->calls;
            }
        });

        $dispatcher->dispatch(new TestEvent());

        self::assertEquals(1, $subscriber->calls);
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
