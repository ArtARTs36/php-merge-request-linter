<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Events;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var array<string|class-string, array<callable(object): void>> */
    private array $listeners = [];

    public function dispatch(object $event): object
    {
        $eventClass = $event::class;

        foreach ($this->listeners[$eventClass] ?? [] as $listener) {
            $listener($event);
        }

        if (defined("$eventClass::NAME")) {
            foreach ($this->listeners[$eventClass::NAME] ?? [] as $listener) {
                $listener($event);
            }
        }

        return $event;
    }

    /**
     * @param string|class-string $event
     * @param callable(object): void $listener
     */
    public function listen(string $event, callable $listener): void
    {
        $this->listeners[$event][] = $listener;
    }

    public function subscribe(EventSubscriber $subscriber): void
    {
        foreach ($subscriber->getSubscribedEvents() as $eventName => $methodName) {
            $this->listen($eventName, $subscriber->$methodName(...));
        }
    }
}
