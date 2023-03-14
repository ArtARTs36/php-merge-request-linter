<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;

class BitbucketPipelines implements CiSystem
{
    public const NAME = 'bitbucket_pipelines';

    public function __construct(
        private readonly Client $client,
        private readonly BitbucketEnvironment $environment,
        private readonly MarkdownCleaner $markdownCleaner,
    ) {
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
        ));

        $description = Str::make($pr->description);

        return new MergeRequest(
            Str::make($pr->title),
            new Markdown($description),
            $this->markdownCleaner->clean($description),
            new Set([]),
            false,
            Str::make($pr->sourceBranch),
            Str::make($pr->targetBranch),
            new Author(Str::make($pr->authorNickname)),
            $pr->isDraft(),
            $pr->canMerge(),
            $this->mapChanges($pr),
            $pr->createdAt,
            Str::make($pr->uri),
        );
    }

    private function mapChanges(PullRequest $request): Map
    {
        return new MapProxy(function () use ($request) {
            $changes = [];

            foreach ($request->changes as $filename => $diff) {
                $changes[$filename] = new \ArtARTs36\MergeRequestLinter\Domain\Request\Change(
                    $filename,
                    new Diff($diff),
                );
            }

            return new ArrayMap($changes);
        });
    }
}
