<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

class FileChange
{
    public function __construct(
        public readonly string $file,
        public readonly ?string $contains,
        public readonly ?string $containsRegex,
        public readonly ?string $updatedPhpConstant,
    ) {
        //
    }
}
