<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

class NeedFileChange
{
    public function __construct(
        public readonly string $file,
        public readonly ?string $contains,
        public readonly ?string $containsRegex,
        public readonly ?string $updatedPhpConstant,
    ) {
        //
    }

    public function hasConditions(): bool
    {
        return $this->contains !== null || $this->containsRegex !== null || $this->updatedPhpConstant !== null;
    }
}
