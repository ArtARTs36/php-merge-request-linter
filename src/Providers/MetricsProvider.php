<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\MetricStorageFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\RequestMetricFlusher;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Manager\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\NullStorage;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Client;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer;
use Psr\Container\ContainerInterface;

final class MetricsProvider extends Provider
{
    public function provide(): void
    {;
        $this
            ->container
            ->get(EventManager::class)
            ->listen(ConfigResolvedEvent::class, new CallbackListener('register metric storage', function (ConfigResolvedEvent $event) {
                $this->container->bind(MetricStorage::class, static function (ContainerInterface $container) use ($event) {
                    $httpClient = $container->get(ClientFactory::class)->create($event->config->config->httpClient);

                    return (new MetricStorageFactory($httpClient))->create($event->config->config->metrics->storage);
                });
            }));

        $this
            ->container
            ->get(EventManager::class)
            ->listen(LintFinishedEvent::class, new CallbackListener('metrics_flush', function (LintFinishedEvent $event) {
                $flusher = new RequestMetricFlusher(
                    $this->container->get(MetricManager::class),
                    $this->container->get(MetricStorage::class),
                );

                $flusher->flush($event->request);
            }));
    }
}
