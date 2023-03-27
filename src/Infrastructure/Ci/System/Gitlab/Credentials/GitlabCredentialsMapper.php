<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;

class GitlabCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    public function map(array $credentials): Authenticator
    {
        if (empty($credentials['token']) || ! is_string($credentials['token'])) {
            throw new InvalidCredentialsException(sprintf(
                'Gitlab CI supported only token',
            ));
        }

        return new TokenAuthenticator('PRIVATE-TOKEN', $this->valueTransformer->tryTransform($credentials['token']));
    }
}
