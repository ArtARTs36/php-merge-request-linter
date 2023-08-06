<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input;

/**
 * @codeCoverageIgnore
 */
class Input
{
    public function __construct(
        public readonly string $apiUrl,
    ) {
        //
    }
}
