<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

class User
{
    public function __construct(
        public string $workDirectory,
        public ?string $customPath,
    ) {
        //
    }
}
