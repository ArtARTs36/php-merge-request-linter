<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Events\EventListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventSubscriber;
use PHPUnit\Framework\Assert;

class MockEventDispatcher implements EventManager
{
    public array $listeners = [];

    /** @var array<class-string, array<array>> */
    private array $dispatchedEvents = [];

    public function dispatch(object $event)
    {
        $this->dispatchedEvents[get_class($event)][] = json_encode($event);
    }

    public function listen(string $event, EventListener $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        // TODO: Implement subscribe() method.
    }

    public function assertDispatched(string $eventName, array $eventData): void
    {
        $dispatched = false;
        $similar = [];
        $eventData = json_encode($eventData);

        foreach ($this->dispatchedEvents[$eventName] ?? [] as $data) {
            if ($eventData === $data) {
                $dispatched = true;

                break;
            }

            $similar[] = $data;
        }

        if (count($similar) === 0) {
            $msg = sprintf('Event %s not dispatched', $eventName);
        } else {
            $msg = sprintf(
                'Event %s not dispatched, but have %d similar dispatched events: %s',
                $eventName,
                count($similar),
                json_encode($similar, JSON_PRETTY_PRINT),
            );
        }

        Assert::assertTrue($dispatched, $msg);
    }

    public function assertDispatchedObject(object $event): void
    {
        $this->assertDispatched(get_class($event), get_object_vars($event));
    }

    /**
     * @param array<object> $events
     */
    public function assertDispatchedObjectList(array $events): void
    {
        foreach ($events as $event) {
            $this->assertDispatchedObject($event);
        }
    }
}
