<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

/**
 * @codeCoverageIgnore
 */
class CiSettings
{
    /**
     * @param array<string, mixed> $params
     */
    public function __construct(
        public readonly Authenticator $credentials,
        public readonly array $params,
    ) {
        //
    }
}
