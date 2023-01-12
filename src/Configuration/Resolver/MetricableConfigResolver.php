<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Resolver;

use ArtARTs36\MergeRequestLinter\Configuration\User;
use ArtARTs36\MergeRequestLinter\Contracts\Report\MetricManager;
use ArtARTs36\MergeRequestLinter\Report\MetricSubject;
use ArtARTs36\MergeRequestLinter\Support\Time\Timer;

class MetricableConfigResolver implements \ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver
{
    public function __construct(
        private readonly \ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigResolver $resolver,
        private readonly MetricManager $metrics,
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
