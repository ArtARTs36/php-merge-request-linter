<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;

class BitbucketCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    public function map(array|string $value): Authenticator
    {
        if (is_string($value)) {
            return Token::bearer($value);
        }

        $authenticators = [];

        if (array_key_exists('host', $value)) {
            $authenticators[] = new HostAuthenticator($value['host']);
        }

        if (array_key_exists('app_password', $value) && count($value['app_password']) === 2) {
            foreach ($value['app_password'] as &$v) {
                if ($this->valueTransformer->supports($v)) {
                    $v = $this->valueTransformer->transform($v);
                }
            }

            $authenticators[] = new BasicBase64($value['app_password']['user'], $value['app_password']['password']);
        }

        return new CompositeAuthenticator($authenticators);
    }
}
