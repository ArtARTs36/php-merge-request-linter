<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

final class HostAuthenticator implements Authenticator
{
    public function __construct(
        private readonly string $host,
    ) {
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        $newUri = $request->getUri()->withHost($this->host);

        return $request->withUri($newUri);
    }
}
