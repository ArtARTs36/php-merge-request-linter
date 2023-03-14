<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;

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
            throw new InvalidCredentialsException(sprintf(
                'Github Actions supported only token',
            ));
        }

        return TokenAuthenticator::bearer($this->value->tryTransform($credentials['token']));
    }
}
