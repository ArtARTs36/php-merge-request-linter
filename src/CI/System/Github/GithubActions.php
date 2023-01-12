<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github;

use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Diff;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
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
        try {
            return $this->env->getMergeRequestId() >= 0;
        } catch (EnvironmentVariableNotFound) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $graphqlUrl = $this->env->getGraphqlURL();
        $repo = $this->env->extractRepo();
        $requestId = $this->env->getMergeRequestId();

        $pullRequest = $this->client->getPullRequest(new PullRequestInput(
            $graphqlUrl,
            $repo->owner,
            $repo->name,
            $requestId,
        ));

        return new MergeRequest(
            Str::make($pullRequest->title),
            Str::make($pullRequest->bodyText),
            Set::fromList($pullRequest->labels),
            $pullRequest->hasConflicts(),
            Str::make($pullRequest->headRefName),
            Str::make($pullRequest->baseRefName),
            new Author($pullRequest->authorLogin),
            $pullRequest->isDraft,
            $pullRequest->canMerge(),
            $this->mapChanges($pullRequest),
        );
    }

    /**
     * @return Map<string, \ArtARTs36\MergeRequestLinter\Request\Data\Change>
     */
    private function mapChanges(PullRequest $request): Map
    {
        return new MapProxy(function () use ($request) {
            $changes = [];

            foreach ($request->changes as $change) {
                $changes[$change->filename] = new \ArtARTs36\MergeRequestLinter\Request\Data\Change(
                    $change->filename,
                    new Diff($change->diff),
                );
            }

            return new ArrayMap($changes);
        }, $request->changedFiles);
    }
}
