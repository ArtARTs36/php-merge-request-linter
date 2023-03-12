<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

final class TokenAuthenticator implements Authenticator
{
    public function __construct(
        private readonly string $header,
        private readonly string $token,
    ) {
        //
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader($this->header, $this->token);
    }

    public static function bearer(string $token): self
    {
        return new self('Authorization', 'Bearer ' . $token);
    }

    /**
     * @return array<string, string>
     */
    public function __debugInfo(): array
    {
        return [
            'header' => $this->header,
            'token'  => '******',
        ];
    }
}
