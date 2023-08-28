<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;

class BitbucketEnvironment
{
    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    public function isWorking(): bool
    {
        return $this->environment->has(VarName::ProjectKey->value);
    }

    /**
     * @throws EnvironmentException
     */
    public function getRepo(): Repo
    {
        $workspace = $this->environment->getString(VarName::Workspace->value);
        $repoName = $this->environment->getString(VarName::RepoName->value);

        return new Repo($workspace, $repoName);
    }

    /**
     * @throws EnvironmentException
     */
    public function getPullRequestId(): int
    {
        return $this->environment->getInt(VarName::PullRequestId->value);
    }
}
