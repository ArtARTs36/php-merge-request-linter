<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;

class GithubActionsCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $value,
    ) {
        //
    }

    public function map(array|string $credentials): Authenticator
    {
        return Token::bearer($this->value->tryTransform(is_array($credentials) ? reset($credentials) : $credentials));
    }
}
