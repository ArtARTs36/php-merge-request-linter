<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

/**
 * @codeCoverageIgnore
 */
class Form
{
    /**
     * @param array<mixed> $body
     */
    public function __construct(
        public readonly array $body,
    ) {
        //
    }
}
