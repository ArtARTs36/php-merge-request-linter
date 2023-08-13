<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
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

        if (! is_string($credentials['token'])) {
            throw new InvalidCredentialsException('Bitbucket token must be string');
        }

        $token = $this->valueTransformer->tryTransform($credentials['token']);

        if (empty($token)) {
            throw new InvalidCredentialsException('Given empty bitbucket token');
        }

        return HeaderAuthenticator::bearer($token);
    }

    /**
     * @param array<string, mixed> $credentials
     */
    private function createHostAuthenticator(array $credentials): ?Authenticator
    {
        if (! array_key_exists('host', $credentials)) {
            return null;
        }

        if (! is_string($credentials['host'])) {
            throw new InvalidCredentialsException('Bitbucket host must be string');
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
        if (! array_key_exists('app_password', $credentials)) {
            return null;
        }

        if (! is_array($credentials['app_password'])) {
            throw new InvalidCredentialsException('Value of key "app_password" must be array');
        }

        $user = $this->getAppPasswordSubject($credentials['app_password'], 'user');
        $password = $this->getAppPasswordSubject($credentials['app_password'], 'password');

        return new BasicBase64Authenticator($user, $password);
    }

    /**
     * @param array<mixed> $credentials
     * @throws InvalidCredentialsException
     */
    private function getAppPasswordSubject(array $credentials, string $subject): string
    {
        if (! array_key_exists($subject, $credentials)) {
            throw new InvalidCredentialsException(sprintf('Key "app_password.%s" not found', $subject));
        }

        $v = $credentials[$subject];

        if (! is_string($v)) {
            throw new InvalidCredentialsException(sprintf('Value of key "app_password.%s" must be string', $subject));
        }

        $v = $this->valueTransformer->tryTransform($v);

        if (empty($v)) {
            throw new InvalidCredentialsException(sprintf('Given empty bitbucket app_password.%s', $subject));
        }

        return $v;
    }
}
