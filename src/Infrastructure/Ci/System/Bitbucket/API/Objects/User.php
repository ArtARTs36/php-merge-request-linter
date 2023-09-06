<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

/**
 * @codeCoverageIgnore
 */
readonly class User
{
    public function __construct(
        public string $displayName,
        public string $accountId,
    ) {
    }
}
