<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github;

use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\VarName;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Str;

class GithubActions implements CiSystem
{
    use InteractsWithResponse;

    public const NAME = 'github_actions';

    public function __construct(
        protected GithubEnvironment $env,
        protected GithubClient $client,
    ) {
        //
    }

    public static function is(Environment $environment): bool
    {
        return $environment->has(VarName::Identity->value);
    }

    public function isMergeRequest(): bool
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
            $pullRequest->changedFiles,
            new Author($pullRequest->authorLogin),
            $pullRequest->isDraft,
            $pullRequest->canMerge(),
        );
    }
}
