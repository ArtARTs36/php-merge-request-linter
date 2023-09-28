<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Registry\CollectorRegistry;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;

class MetricableConfigResolver implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver
{
    public function __construct(
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver $resolver,
        private readonly CollectorRegistry                                                                   $metrics,
    ) {
    }

    public function resolve(User $user, int $configSubjects = Config::SUBJECT_ALL): ResolvedConfig
    {
        $timer = Timer::start();

        $config = $this->resolver->resolve($user, $configSubjects);

        $this->metrics->register(
            new \ArtARTs36\MergeRequestLinter\Shared\Metrics\Collector\Gauge(
                new MetricSubject('config', 'resolving_time', 'Duration of config resolving'),
                [],
                $timer->finish()->seconds,
            ),
        );

        return $config;
    }
}
