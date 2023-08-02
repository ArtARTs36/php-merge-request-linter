<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

/**
 * @codeCoverageIgnore
 */
class User
{
    public function __construct(
        public readonly string $displayName,
        public readonly string $accountId,
    ) {
        //
    }
}
