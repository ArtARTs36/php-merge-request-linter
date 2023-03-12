<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;

class BitbucketPipelines implements CiSystem
{
    public const NAME = 'bitbucket_pipelines';

    public function __construct(
        private readonly Client $client,
        private readonly BitbucketEnvironment $environment,
    )
    {
        //
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->environment->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
    {
        try {
            return $this->environment->getPullRequestId() > 0;
        } catch (EnvironmentVariableNotFoundException) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $repo = $this->environment->getRepo();
        $prId = $this->environment->getPullRequestId();

        $pr = $this->client->getPullRequest(new PullRequestInput(
            $repo->workspace,
            $repo->slug,
            $prId,
            $this->environment->getHost(),
        ));

        return new MergeRequest(
            Str::make($pr->title),
            new Markdown(Str::fromEmpty()),
            Str::fromEmpty(),
            new Set([]),
            false,
            Str::make($pr->sourceBranch),
            Str::make($pr->targetBranch),
            new Author(Str::make($pr->authorNickname)),
            false,
            true,
            new ArrayMap([]),
            $pr->createdAt,
            Str::make($pr->uri),
        );
    }
}
