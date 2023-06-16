<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects;

/**
 * @codeCoverageIgnore
 */
class CreatedComment
{
    public function __construct(
        public readonly int $id,
        public readonly string $url,
    ) {
        //
    }
}
