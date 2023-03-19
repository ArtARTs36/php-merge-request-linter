<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client as APIClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\DescriptionLabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\BitbucketPipelinesSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use League\CommonMark\CommonMarkConverter;
use Psr\Log\LoggerInterface;

final class BitbucketPipelinesCreator implements SystemCreator
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
        $labelsSettings = new LabelsSettings(
            $settings->params['labels']['of_description'] ?? null,
        );

        return new BitbucketPipelines(
            new APIClient($settings->credentials, $this->httpClient, $this->logger, new NativeJsonDecoder()),
            new BitbucketEnvironment($this->environment),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
            new BitbucketPipelinesSettings($labelsSettings),
            new CompositeResolver([
                new DescriptionLabelsResolver(),
            ]),
        );
    }
}
