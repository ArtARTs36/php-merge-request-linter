<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Linter;

use ArtARTs36\MergeRequestLinter\Application\Linter\Runner;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterRunner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelinesCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActionsCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCiCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Linter\LinterRunnerFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\RequestFetcher\CiRequestFetcher;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
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
                $this->createSystemFactory($config),
                $this->metrics,
            ),
        );
    }

    private function createSystemFactory(Config $config): SystemFactory
    {
        $httpClient = (new ClientFactory($this->metrics))->create($config->getHttpClient());

        return new SystemFactory(
            $config,
            new ArrayMap([
                GithubActions::NAME => new GithubActionsCreator($this->environment, $httpClient, $this->logger),
                GitlabCi::NAME => new GitlabCiCreator($this->environment, $httpClient, $this->logger),
                BitbucketPipelines::NAME => new BitbucketPipelinesCreator($this->environment, $httpClient, $this->logger),
            ]),
        );
    }
}
