<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

class NullAuthenticator implements Authenticator
{
    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request;
    }
}
