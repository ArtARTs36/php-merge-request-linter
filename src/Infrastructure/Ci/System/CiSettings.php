<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

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
