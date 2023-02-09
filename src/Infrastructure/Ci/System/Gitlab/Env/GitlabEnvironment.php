<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env;

use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\EnvironmentVariableNotFoundException;

class GitlabEnvironment
{
    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    public function isWorking(): bool
    {
        return $this->environment->has(VarName::Identity->value);
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function getProjectId(): int
    {
        return $this->environment->getInt(VarName::ProjectID->value);
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function getGitlabServerUrl(): string
    {
        return $this->environment->getString(VarName::ApiURL->value);
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function getMergeRequestId(): int
    {
        return $this->environment->getInt(VarName::RequestID->value);
    }
}
