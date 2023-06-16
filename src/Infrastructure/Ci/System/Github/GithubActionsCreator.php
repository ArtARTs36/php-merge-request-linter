<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;

final class GithubActionsCreator implements SystemCreator
{
    public function __construct(
        private readonly Environment   $environment,
        private readonly HttpClient    $httpClient,
        private readonly ContextLogger $logger,
        private readonly Clock    $clock,
    ) {
        //
    }

    public function create(CiSettings $settings): CiSystem
    {
        return new GithubActions(new GithubEnvironment($this->environment), new Client(
            $this->httpClient,
            $settings->credentials,
            new PullRequestSchema($this->clock),
            $this->logger,
            new NativeJsonProcessor(),
            new ChangeSchema(new DiffMapper()),
        ), $this->logger);
    }
}
