<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use Psr\Log\LoggerInterface;

final class GithubActionsCreator implements SystemCreator
{
    public function __construct(
        private readonly Environment $environment,
        private readonly HttpClient $httpClient,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function create(CiSettings $settings): CiSystem
    {
        return new GithubActions(new GithubEnvironment($this->environment), new Client(
            $this->httpClient,
            $settings->credentials,
            new PullRequestSchema(),
            new DiffMapper(),
            $this->logger,
        ));
    }
}
