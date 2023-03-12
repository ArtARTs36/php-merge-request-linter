<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

class CompositeAuthenticator implements Authenticator
{
    /**
     * @param iterable<Authenticator> $authenticators
     */
    public function __construct(
        private readonly iterable $authenticators,
    ) {
        //
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        foreach ($this->authenticators as $authenticator) {
            $authenticator->authenticate($request);
        }

        return $request;
    }
}
