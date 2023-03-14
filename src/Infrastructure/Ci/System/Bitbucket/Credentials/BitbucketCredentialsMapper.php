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

    public function map(array|string $value): Authenticator
    {
        $authenticators = [];

        if (array_key_exists('token', $value)) {
            $authenticators[] = TokenAuthenticator::bearer($this->valueTransformer->tryTransform($value['token']));
        }

        if (array_key_exists('host', $value)) {
            $authenticators[] = new HostAuthenticator($this->valueTransformer->tryTransform($value['host']));
        }

        if (array_key_exists('app_password', $value) && count($value['app_password']) === 2) {
            foreach ($value['app_password'] as &$v) {
                if ($this->valueTransformer->supports($v)) {
                    $v = $this->valueTransformer->transform($v);
                }
            }

            $authenticators[] = new BasicBase64Authenticator($value['app_password']['user'], $value['app_password']['password']);
        }

        return new CompositeAuthenticator($authenticators);
    }
}
