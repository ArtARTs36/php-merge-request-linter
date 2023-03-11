<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;

class BitbucketEnvironment
{
    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function getPipelinesToken(): string
    {
        return $this->environment->getString(VarName::PipelinesToken->value);
    }

    public function isWorking(): bool
    {
        return $this->environment->has(VarName::ProjectKey->value);
    }

    public function getRepo(): Repo
    {
        $projectKey = $this->environment->getString(VarName::ProjectKey->value);
        $repoName = $this->environment->getString(VarName::RepoName->value);

        return new Repo($projectKey, $repoName);
    }

    public function getHost(): string
    {
        $origin = $this->environment->getString(VarName::HttpOrigin->value);

        return parse_url($origin, PHP_URL_HOST);
    }

    public function getPullRequestId(): int
    {
        return $this->environment->getInt(VarName::PullRequestId->value);
    }
}