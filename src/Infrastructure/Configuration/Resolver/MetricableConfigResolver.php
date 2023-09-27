<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricSubject;
use ArtARTs36\MergeRequestLinter\Shared\Time\Timer;

class MetricableConfigResolver implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver
{
    public function __construct(
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver $resolver,
        private readonly MetricManager                                                                       $metrics,
    ) {
    }

    public function resolve(User $user, int $configSubjects = Config::SUBJECT_ALL): ResolvedConfig
    {
        $timer = Timer::start();

        $config = $this->resolver->resolve($user, $configSubjects);

        $this->metrics->add(
            new MetricSubject('config', 'resolving_time', 'Duration of config resolving'),
            $timer->finish(),
        );

        return $config;
    }
}
