<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\NotificationEvent\ListenerRegistrar;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\MessageCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Notifier\NotifierFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Renderer\TwigRenderer;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use Psr\Clock\ClockInterface;

/**
 * @codeCoverageIgnore
 */
final class NotificationsProvider extends Provider
{
    public function provide(): void
    {
        $notificationsListener = function (ConfigResolvedEvent $event) {
            $this
                ->createNotificationsListenerRegistrar($event->config->config)
                ->register($this->container->get(EventManager::class));
        };

        $this
            ->container
            ->get(EventManager::class)
            ->listen(ConfigResolvedEvent::class, new CallbackListener(
                'registration notifications',
                $notificationsListener,
            ));
    }

    private function createNotificationsListenerRegistrar(Config $config): ListenerRegistrar
    {
        $logger = $this->container->get(ContextLogger::class);

        $notifier = (new NotifierFactory(
            $this->container->get(HttpClientFactory::class)->create(
                $config->httpClient,
            ),
            $this->container->get(ClockInterface::class),
            $logger,
        ))->create();

        return new ListenerRegistrar(
            $config->notifications,
            new ListenerFactory(
                $notifier,
                $this->container->get(OperatorResolver::class),
                new MessageCreator(TwigRenderer::create()),
                $logger,
            ),
        );
    }
}
