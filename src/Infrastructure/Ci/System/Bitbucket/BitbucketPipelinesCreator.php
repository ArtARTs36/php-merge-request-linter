<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use League\CommonMark\CommonMarkConverter;
use Psr\Log\LoggerInterface;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client as APIClient;

class BitbucketPipelinesCreator implements SystemCreator
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
        return new BitbucketPipelines(
            new APIClient($settings->credentials, $this->httpClient, $this->logger),
            new BitbucketEnvironment($this->environment),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
        );
    }
}
