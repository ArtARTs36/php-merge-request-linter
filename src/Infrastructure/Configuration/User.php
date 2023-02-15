<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration;

class User
{
    public function __construct(
        public string $workDirectory,
        public ?string $customPath,
    ) {
        //
    }
}
