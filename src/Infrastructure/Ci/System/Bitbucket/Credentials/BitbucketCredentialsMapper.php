<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;

class BitbucketCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    public function map(array $credentials): Authenticator
    {
        $authenticators = [];

        if (! empty($credentials['token'])) {
            $authenticators[] = TokenAuthenticator::bearer($this->valueTransformer->tryTransform($credentials['token']));
        }

        if (array_key_exists('host', $credentials)) {
            $authenticators[] = new HostAuthenticator($this->valueTransformer->tryTransform($credentials['host']));
        }

        if (array_key_exists('app_password', $credentials) && count($credentials['app_password']) === 2) {
            foreach ($credentials['app_password'] as &$v) {
                $v = $this->valueTransformer->tryTransform($v);
            }

            $authenticators[] = new BasicBase64Authenticator($credentials['app_password']['user'], $credentials['app_password']['password']);
        }

        return new CompositeAuthenticator($authenticators);
    }
}
