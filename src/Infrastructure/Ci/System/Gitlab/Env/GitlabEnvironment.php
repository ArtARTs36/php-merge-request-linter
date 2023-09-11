<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;

class GitlabEnvironment
{
    public function __construct(
        private readonly Environment $environment,
    ) {
    }

    public function isWorking(): bool
    {
        return $this->environment->has(VarName::Identity->value);
    }

    /**
     * @throws EnvironmentException
     */
    public function getProjectId(): int
    {
        return $this->environment->getInt(VarName::ProjectID->value);
    }

    /**
     * @throws EnvironmentException
     */
    public function getGitlabServerUrl(): string
    {
        return $this->environment->getString(VarName::ApiURL->value);
    }

    /**
     * @throws EnvironmentException
     */
    public function getMergeRequestNumber(): int
    {
        return $this->environment->getInt(VarName::RequestNumber->value);
    }
}
