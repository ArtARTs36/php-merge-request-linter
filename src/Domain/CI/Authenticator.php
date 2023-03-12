<?php

namespace ArtARTs36\MergeRequestLinter\Domain\CI;

use Psr\Http\Message\RequestInterface;

/**
 * Remote credentials for remote git hosting
 */
interface Authenticator
{
    /**
     * Authenticate request.
     */
    public function authenticate(RequestInterface $request): RequestInterface;
}
