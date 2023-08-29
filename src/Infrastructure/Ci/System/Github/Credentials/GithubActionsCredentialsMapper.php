<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\TransformConfigValueException;
use ArtARTs36\Str\Facade\Str;

class GithubActionsCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $value,
    ) {
        //
    }

    public function map(array $credentials): Authenticator
    {
        if (empty($credentials['token'])) {
            throw new InvalidCredentialsException('Github Actions supported only token');
        }

        if (! is_string($credentials['token'])) {
            throw new InvalidCredentialsException('Github Actions needs token as string');
        }

        try {
            $token = $this->value->tryTransform($credentials['token']);

            if (Str::isEmpty($token)) {
                throw new InvalidCredentialsException('Failed to resolve github token: token is empty');
            }

            return HeaderAuthenticator::bearer($token);
        } catch (TransformConfigValueException $e) {
            throw new InvalidCredentialsException(sprintf(
                'Failed to resolve github token: %s',
                $e->getMessage(),
            ), previous: $e);
        }
    }
}
