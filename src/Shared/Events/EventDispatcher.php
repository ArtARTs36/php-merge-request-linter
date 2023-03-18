<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\Events\EventManager;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class EventDispatcher implements EventManager
{
    /** @var array<string|class-string, array<EventListener>> */
    private array $listeners = [];

    public function __construct(
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
        //
    }

    public function dispatch(object $event): object
    {
        $eventClass = $event::class;
        $eventName = defined("$eventClass::NAME") ? $eventClass::NAME : null;
        $eventLogName = $eventName ?? $eventClass;

        $this->logger->info(
            sprintf('[EventDispatcher][event: %s] Dispatching event "%s"', $eventLogName, $eventLogName),
            ['event_data' => get_object_vars($event)],
        );

        $this->callListeners($this->listeners[$eventClass] ?? [], $event, $eventLogName);

        if ($eventName !== null) {
            $this->callListeners($this->listeners[$eventName] ?? [], $event, $eventLogName);
        }

        return $event;
    }

    public function listen(string $event, EventListener $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $methodName) {
            $this->listen($eventName, new CallbackListener(
                sprintf('%s::%s', get_class($subscriber), $methodName),
                $subscriber->$methodName(...),
            ));
        }
    }

    /**
     * @param iterable<EventListener> $listeners
     */
    private function callListeners(iterable $listeners, object $event, string $eventLogName): void
    {
        foreach ($listeners as $listener) {
            $this->logger->info(
                sprintf('[EventDispatcher][event: %s] Calling listener "%s"', $eventLogName, $listener->name()),
            );

            $listener->call($event);

            $this->logger->info(
                sprintf('[EventDispatcher][event: %s] Listener "%s" called', $eventLogName, $listener->name()),
            );
        }
    }
}
