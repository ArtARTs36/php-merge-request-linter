<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Logger\ContextLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Logger\NullContextLogger;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\Events\EventManager;

class EventDispatcher implements EventManager
{
    /** @var array<string|class-string, array<EventListener>> */
    private array $listeners = [];

    public function __construct(
        private readonly ContextLogger $logger = new NullContextLogger(),
    ) {
        //
    }

    public function dispatch(object $event): object
    {
        $eventId = uniqid();

        $this->logger->shareContext('event_id', $eventId);

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

        $this->logger->info(sprintf('[EventDispatcher][event: %s] All listeners was called', $eventLogName));

        $this->logger->clearContext('event_id');

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
     * @throws EventListenerWasFailedException
     */
    private function callListeners(iterable $listeners, object $event, string $eventLogName): void
    {
        foreach ($listeners as $listener) {
            $this->logger->info(
                sprintf('[EventDispatcher][event: %s] Calling listener "%s"', $eventLogName, $listener->name()),
            );

            try {
                $listener->call($event);
            } catch (\Throwable $e) {
                $this->logger->error(sprintf(
                    '[EventDispatcher][event: %s] Listener "%s" was failed: %s',
                    $eventLogName,
                    $listener->name(),
                    $e->getMessage(),
                ));

                throw new EventListenerWasFailedException(
                    $e->getMessage(),
                    $e->getCode(),
                    $e,
                );
            }

            $this->logger->info(
                sprintf('[EventDispatcher][event: %s] Listener "%s" was called', $eventLogName, $listener->name()),
            );
        }
    }
}
