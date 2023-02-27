<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Notifications;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

class Message
{
    /**
     * @param Map<string, mixed> $data
     */
    public function __construct(
        public readonly string $template,
        public readonly Map    $data,
    ) {
        //
    }
}
