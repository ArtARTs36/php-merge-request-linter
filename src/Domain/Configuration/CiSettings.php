<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

/**
 * @codeCoverageIgnore
 */
readonly class CiSettings
{
    /**
     * @param array<string, mixed> $params
     */
    public function __construct(
        public Authenticator $credentials,
        public array         $params,
    ) {
        //
    }
}
