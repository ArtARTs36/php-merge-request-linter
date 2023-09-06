<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Contracts\Notifier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextRenderingFailedException;

class NotifyListener implements Listener
{
    public function __construct(
        private readonly Notifier                 $notifier,
        private readonly NotificationEventMessage $message,
        private readonly MessageCreator           $messageCreator,
        private readonly ContextLogger            $logger,
    ) {
    }

    public function handle(object $event): void
    {
        try {
            $message = $this->messageCreator->create(
                $this->message->template,
                get_object_vars($event),
            );
        } catch (TextRenderingFailedException $e) {
            throw new NotifyFailedException(sprintf(
                'Rendering template for notification on event "%s" was failed: %s',
                $this->message->event,
                $e->getMessage(),
            ), previous: $e);
        }

        $this->logger->shareContext('message_id', $message->id);

        $this->notifier->notify(
            $this->message->channel,
            $message,
        );

        $this->logger->clearContext('message_id');
    }
}
