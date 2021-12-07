<?php

namespace ArtARTs36\MergeRequestLinter\Request;

class ChangedFile
{
    public function __construct(
        public string $currentPath,
    ) {
        //
    }
}
