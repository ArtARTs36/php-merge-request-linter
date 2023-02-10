<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Runner;

use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\MetricManager;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use Psr\Log\LoggerInterface;

class RunnerFactory implements LinterRunnerFactory
{
    /**
     * @param Map<string, class-string<CiSystem>> $ciSystems
     */
    public function __construct(
        protected Environment $environment,
        protected Map $ciSystems,
        protected LoggerInterface $logger,
        protected MetricManager $metrics,
    ) {
        //
    }

    public function create(Config $config): LinterRunner
    {
        return new Runner(
            new CiRequestFetcher(
                new SystemFactory(
                    $config,
                    $this->environment,
                    new ClientFactory($this->metrics),
                    $this->ciSystems,
                    $this->logger,
                ),
                $this->metrics,
            ),
        );
    }
}
