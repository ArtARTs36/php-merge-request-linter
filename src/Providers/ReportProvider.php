<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Application\Report\Reporter\ReporterFactory;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class ReportProvider extends Provider
{
    public function provide(): void
    {
        $this
            ->container
            ->bind(ReporterFactory::class, static function (ContainerInterface $container) {
                return new ReporterFactory(
                    $container->get(MetricManager::class),
                    $container->get(LoggerInterface::class),
                );
            });

        $this
            ->container
            ->get(EventManager::class)
            ->listen(LintFinishedEvent::class, new CallbackListener('reporter', function (LintFinishedEvent $event) {
                $factory = $this->container->get(ReporterFactory::class);

                $factory->create('prometheusPushGateway', [])->report($event->request, $event->result);
            }));
    }
}
