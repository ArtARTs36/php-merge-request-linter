<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System\Github\Env;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\Str\Str;

class GithubEnvironment
{
    private const REQUEST_ID_SUFFIX = '/merge';
    private const REPO_SEPARATOR = '/';

    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    public function getMergeRequestId(): int
    {
        $ref = $this->environment->getString(VarName::RefName->value);

        $refStr = Str::make($ref);

        $id = $refStr->deleteWhenEnds(self::REQUEST_ID_SUFFIX);

        if (! $id->isDigit()) {
            throw new EnvironmentVariableNotFound(VarName::RefName->value);
        }

        return $id->toInteger();
    }

    public function getGraphqlURL(): string
    {
        return $this->environment->getString(VarName::GraphqlURL->value);
    }

    public function extractRepo(): Repo
    {
        $repo = $this->environment->getString(VarName::Repository->value);

        [$owner, $name] = \ArtARTs36\Str\Facade\Str::explode($repo, self::REPO_SEPARATOR);

        return new Repo($owner, $name);
    }
}
