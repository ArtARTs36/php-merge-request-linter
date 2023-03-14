<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

final class CounterAuthenticator implements Authenticator
{
    public function __construct(public int $calls = 0)
    {
        //
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        ++$this->calls;

        return $request;
    }
}
