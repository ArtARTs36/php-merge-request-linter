<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\MetricManager;
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
        protected ClientFactory $clientFactory,
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
