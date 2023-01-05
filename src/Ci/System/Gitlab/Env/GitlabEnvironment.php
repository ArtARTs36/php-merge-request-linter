<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\Env;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;

class GitlabEnvironment
{
    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    public function getProjectId(): int
    {
        return $this->environment->getInt(VarName::ProjectID->value);
    }

    public function getGitlabServerUrl(): string
    {
        return $this->environment->getString(VarName::ApiURL->value);
    }

    public function getMergeRequestId(): int
    {
        return $this->environment->getInt(VarName::RequestID->value);
    }
}
