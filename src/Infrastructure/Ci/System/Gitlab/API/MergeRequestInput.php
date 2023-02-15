<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

class MergeRequestInput
{
    public function __construct(
        public readonly string $apiUrl,
        public readonly int $projectId,
        public readonly int $requestId,
    ) {
        //
    }
}
