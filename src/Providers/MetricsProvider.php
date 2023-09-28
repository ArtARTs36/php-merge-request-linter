<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Application\Rule\Metrics\RuleLintStateMetricHandler;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasFailedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\RuleWasSuccessfulEvent;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\MetricStorageFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Metrics\RequestMetricFlusher;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;
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
                    $this->container->get(CollectorRegistry::class),
                    $this->container->get(MetricStorage::class),
                );

                $flusher->flush($event->request);
            }));

        $this->container->bind(RuleLintStateMetricHandler::class, static function (ContainerInterface $container) {
            return RuleLintStateMetricHandler::make($container->get(CollectorRegistry::class));
        });

        $this
            ->container
            ->get(EventManager::class)
            ->listen(RuleWasSuccessfulEvent::class, new CallbackListener('rule_lint_successful_state_metric', function (RuleWasSuccessfulEvent $event) {
                $this->container->get(RuleLintStateMetricHandler::class)->handle($event);
            }));

        $this
            ->container
            ->get(EventManager::class)
            ->listen(RuleWasFailedEvent::class, new CallbackListener('rule_lint_failed_state_metric', function (RuleWasFailedEvent $event) {
                $this->container->get(RuleLintStateMetricHandler::class)->handle($event);
            }));
    }
}
