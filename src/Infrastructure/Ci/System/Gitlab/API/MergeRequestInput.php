<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

/**
 * @codeCoverageIgnore
 */
readonly class MergeRequestInput
{
    public function __construct(
        public string $apiUrl,
        public int    $projectId,
        public int    $requestId,
    ) {
    }
}
