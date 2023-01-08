<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API;

class Change
{
    public function __construct(
        public readonly string $newPath,
        public readonly string $oldPath,
    ) {
        //
    }
}
