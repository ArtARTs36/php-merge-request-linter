<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiInvalidParamsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client as APIClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\DescriptionLabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\BitbucketPipelinesSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsOfDescriptionSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\SystemCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use League\CommonMark\CommonMarkConverter;
use Psr\Log\LoggerInterface;

final class BitbucketPipelinesCreator implements SystemCreator
{
    public function __construct(
        private readonly Environment $environment,
        private readonly HttpClient $httpClient,
        private readonly LoggerInterface $logger,
        private readonly Clock $clock,
    ) {
        //
    }

    public function create(CiSettings $settings): CiSystem
    {
        $labelsSettings = new LabelsSettings(
            $this->createLabelsOfDescriptionSettings($settings),
        );

        return new BitbucketPipelines(
            new APIClient(
                $settings->credentials,
                $this->httpClient,
                $this->logger,
                new NativeJsonDecoder(),
                new PullRequestSchema($this->clock),
            ),
            new BitbucketEnvironment($this->environment),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
            new BitbucketPipelinesSettings($labelsSettings),
            new CompositeResolver([
                new DescriptionLabelsResolver(),
            ]),
        );
    }

    /**
     * @throws CiInvalidParamsException
     */
    private function createLabelsOfDescriptionSettings(CiSettings $settings): ?LabelsOfDescriptionSettings
    {
        $data = $settings->params['labels'] ?? null;

        if (! is_array($data)) {
            return null;
        }

        $data = $data['of_description'] ?? null;

        if (! is_array($data)) {
            return null;
        }

        if (! isset($data['line_starts_with']) || ! is_string($data['line_starts_with']) || $data['line_starts_with'] === '') {
            throw new CiInvalidParamsException(
                'labels.of_description.line_starts_with',
                'labels.of_description.line_starts_with must be non empty string',
            );
        }

        if (! isset($data['separator']) || ! is_string($data['separator']) || $data['separator'] === '') {
            throw new CiInvalidParamsException(
                'labels.of_description.separator',
                'labels.of_description.separator must be non empty string',
            );
        }

        return new LabelsOfDescriptionSettings($data['line_starts_with'], $data['separator']);
    }
}
