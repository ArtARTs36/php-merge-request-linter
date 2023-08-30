<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

/**
 * @codeCoverageIgnore
 */
readonly class Form
{
    /**
     * @param array<mixed> $body
     */
    public function __construct(
        public array $body,
    ) {
        //
    }
}
