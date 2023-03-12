<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

final class BasicBase64 implements Authenticator
{
    public function __construct(
        private readonly string $user,
        private readonly string $password,
    ) {
        //
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', 'Basic '. base64_encode("$this->user:$this->password"));
    }

    public function __debugInfo(): ?array
    {
        return null;
    }
}
