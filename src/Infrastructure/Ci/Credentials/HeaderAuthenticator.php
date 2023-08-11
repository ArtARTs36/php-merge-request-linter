<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use Psr\Http\Message\RequestInterface;

final class HeaderAuthenticator implements Authenticator
{
    public function __construct(
        private readonly Header $header,
    ) {
        //
    }

    public static function bearer(string $token): self
    {
        return new self(new Header('Authorization', 'Bearer ' . $token));
    }

    public function authenticate(RequestInterface $request): RequestInterface
    {
        return $request->withHeader($this->header->name, $this->header->value);
    }

    /**
     * @return array<string, string>
     */
    public function __debugInfo(): array
    {
        return [
            'header' => [
                'name' => $this->header->name,
                'value'  => '******',
            ],
        ];
    }
}
