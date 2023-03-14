<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

class AuthenticatorProxy implements Authenticator
{
    private ?Authenticator $authenticator = null;

    /**
     * @param \Closure(): Authenticator $creator
     */
    public function __construct(
        private readonly \Closure $creator,
    ) {
        //
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $this->authenticator()->authenticate($request);
    }

    private function authenticator(): Authenticator
    {
        if ($this->authenticator === null) {
            $this->authenticator = ($this->creator)();
        }

        return $this->authenticator;
    }
}
