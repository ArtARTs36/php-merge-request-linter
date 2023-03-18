<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;

class ListenerRegistrar
{
    public function __construct(
        private readonly NotificationsConfig $config,
        private readonly ListenerFactory $factory,
    ) {
        //
    }

    public function register(EventManager $dispatcher): void
    {
        foreach ($this->config->on as $events) {
            /** @var NotificationEventMessage $eventMsg */
            foreach ($events as $eventMsg) {
                $dispatcher->listen($eventMsg->event, new CallbackListener(
                    'Send notification',
                    function (object $event) use ($eventMsg) {
                        $this->factory->create($eventMsg)->handle($event);
                    },
                ));
            }
        }
    }
}
