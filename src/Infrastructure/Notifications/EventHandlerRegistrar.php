<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventHandlerRegistrar
{
    public function __construct(
        private readonly Notifier $notifier,
        private readonly NotificationsConfig $config,
    ) {
        //
    }

    public function register(EventDispatcher $dispatcher): void
    {
        foreach ($this->config->on as $events) {
            /** @var NotificationEventMessage $eventMsg */
            foreach ($events as $eventMsg) {
                $dispatcher->listen($eventMsg->event, function (object $event) use ($eventMsg) {
                    (new EventHandler($this->notifier, $eventMsg))->handle($event);
                });
            }
        }
    }
}
