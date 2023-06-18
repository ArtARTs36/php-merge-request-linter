<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input;

class GetCommentsInput extends Input
{
    public function __construct(
        string $apiUrl,
        public readonly int $projectId,
        public readonly string $requestNumber,
    ) {
        parent::__construct($apiUrl);
    }
}
