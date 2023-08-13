<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidEnvironmentVariableValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
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

    public function isWorking(): bool
    {
        return $this->environment->has(VarName::Identity->value);
    }

    public function getMergeRequestId(): ?int
    {
        try {
            $ref = $this->environment->getString(VarName::RefName->value);
        } catch (EnvironmentVariableNotFoundException) {
            return null;
        }

        $refStr = Str::make($ref);

        if (! $refStr->endsWith(self::REQUEST_ID_SUFFIX)) {
            return null;
        }

        $id = $refStr->deleteWhenEnds(self::REQUEST_ID_SUFFIX);

        if (! $id->isDigit()) {
            throw new InvalidEnvironmentVariableValueException(sprintf(
                'Var "%s" is invalid. Expected: {id}/merge, given: "%s"',
                VarName::RefName->value,
                $ref,
            ));
        }

        return $id->toInteger();
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function getGraphqlURL(): string
    {
        return $this->environment->getString(VarName::GraphqlURL->value);
    }

    /**
     * @throws EnvironmentException
     * @throws InvalidEnvironmentVariableValueException
     */
    public function extractRepo(): Repo
    {
        $repo = $this->environment->getString(VarName::Repository->value);

        $parts = \ArtARTs36\Str\Facade\Str::explode($repo, self::REPO_SEPARATOR);

        if (count($parts) < 2) {
            throw new InvalidEnvironmentVariableValueException(sprintf(
                'Var "%s" is invalid. Expected: {owner}/{repo}',
                VarName::Repository->value,
            ));
        }

        [$owner, $name] = $parts;

        return new Repo($owner, $name);
    }
}
