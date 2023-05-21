<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use League\CommonMark\CommonMarkConverter;
use Psr\Log\LoggerInterface;

class GitlabCiCreator implements SystemCreator
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
        return new GitlabCi(
            new GitlabEnvironment($this->environment),
            new Client(
                $settings->credentials,
                $this->httpClient,
                new MergeRequestSchema(new DiffMapper()),
                $this->logger,
                new NativeJsonDecoder(),
            ),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
        );
    }
}
