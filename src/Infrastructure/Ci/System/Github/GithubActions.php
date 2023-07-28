<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\CurrentlyNotMergeRequestException;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

class GithubActions implements CiSystem
{
    public const NAME = 'github_actions';

    public function __construct(
        protected GithubEnvironment $env,
        protected GithubClient $client,
    ) {
        //
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->env->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
    {
        return $this->env->getMergeRequestId() !== null;
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $requestId = $this->env->getMergeRequestId();

        if ($requestId === null) {
            throw new CurrentlyNotMergeRequestException();
        }

        $graphqlUrl = $this->env->getGraphqlURL();
        $repo = $this->env->extractRepo();

        $pullRequest = $this->client->getPullRequest(new PullRequestInput(
            $graphqlUrl,
            $repo->owner,
            $repo->name,
            $requestId,
        ));

        return new MergeRequest(
            Str::make($pullRequest->title),
            Str::make($pullRequest->bodyMarkdown)->markdown(),
            Str::make($pullRequest->bodyText),
            Set::fromList($pullRequest->labels),
            $pullRequest->hasConflicts(),
            Str::make($pullRequest->headRefName),
            Str::make($pullRequest->baseRefName),
            new Author(Str::make($pullRequest->authorLogin)),
            $pullRequest->isDraft,
            $pullRequest->canMerge(),
            $this->mapChanges($pullRequest),
            $pullRequest->createdAt,
            Str::make($pullRequest->uri),
        );
    }

    /**
     * @return Map<string, \ArtARTs36\MergeRequestLinter\Domain\Request\Change>
     */
    private function mapChanges(PullRequest $request): Map
    {
        return new MapProxy(function () use ($request) {
            $changes = [];

            foreach ($request->changes as $change) {
                $changes[$change->filename] = new \ArtARTs36\MergeRequestLinter\Domain\Request\Change(
                    $change->filename,
                    $change->diff,
                );
            }

            return new ArrayMap($changes);
        }, $request->changedFiles);
    }
}
