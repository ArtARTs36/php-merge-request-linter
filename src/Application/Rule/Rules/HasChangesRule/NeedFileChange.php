<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

class NeedFileChange
{
    public function __construct(
        #[Description('Relative path to file')]
        public readonly string $file,
        #[Description('Check contains string')]
        public readonly ?string $contains,
        #[Description('Check contains by regex')]
        public readonly ?string $containsRegex,
        #[Description('Check contains updated PHP constant')]
        public readonly ?string $updatedPhpConstant,
    ) {
        //
    }

    public function hasConditions(): bool
    {
        return $this->contains !== null || $this->containsRegex !== null || $this->updatedPhpConstant !== null;
    }
}
