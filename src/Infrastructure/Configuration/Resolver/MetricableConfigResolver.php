<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Common\Time\Timer;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\User;

class MetricableConfigResolver implements \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver
{
    public function __construct(
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigResolver $resolver,
        private readonly MetricManager                                                                       $metrics,
    ) {
        //
    }

    public function resolve(User $user): ResolvedConfig
    {
        $timer = Timer::start();

        $config = $this->resolver->resolve($user);

        $this->metrics->add(
            new MetricSubject('config_resolving_time', '[Config] Duration of config resolving'),
            $timer->finish(),
        );

        return $config;
    }
}
