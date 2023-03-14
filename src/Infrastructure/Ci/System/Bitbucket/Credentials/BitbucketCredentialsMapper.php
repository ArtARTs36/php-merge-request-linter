<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;

class BitbucketCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    public function map(array $credentials): Authenticator
    {
        $mappers = [
            $this->createTokenAuthenticator(...),
            $this->createHostAuthenticator(...),
            $this->createAppPasswordAuthenticator(...),
        ];

        $authenticators = [];

        foreach ($mappers as $mapper) {
            $authenticator = $mapper($credentials);

            if ($authenticator !== null) {
                $authenticators[] = $authenticator;
            }
        }

        return new CompositeAuthenticator($authenticators);
    }

    /**
     * @param array<string, mixed> $credentials
     */
    private function createTokenAuthenticator(array $credentials): ?Authenticator
    {
        if (! array_key_exists('token', $credentials)) {
            return null;
        }

        $token = $this->valueTransformer->tryTransform($credentials['token']);

        if (empty($token)) {
            throw new InvalidCredentialsException('Given empty bitbucket token');
        }

        return TokenAuthenticator::bearer($token);
    }

    /**
     * @param array<string, mixed> $credentials
     */
    private function createHostAuthenticator(array $credentials): ?Authenticator
    {
        if (! array_key_exists('host', $credentials)) {
            return null;
        }

        $host = $this->valueTransformer->tryTransform($credentials['host']);

        if (empty($host)) {
            throw new InvalidCredentialsException('Given empty bitbucket host');
        }

        return new HostAuthenticator($host);
    }

    /**
     * @param array<string, mixed> $credentials
     */
    private function createAppPasswordAuthenticator(array $credentials): ?Authenticator
    {
        if (! array_key_exists('app_password', $credentials) || count($credentials['app_password']) !== 2) {
            return null;
        }

        foreach ($credentials['app_password'] as $k => &$v) {
            $v = $this->valueTransformer->tryTransform($v);

            if (empty($v)) {
                throw new InvalidCredentialsException(sprintf('Given empty bitbucket app_password.%s', $k));
            }
        }

        return new BasicBase64Authenticator($credentials['app_password']['user'], $credentials['app_password']['password']);
    }
}
