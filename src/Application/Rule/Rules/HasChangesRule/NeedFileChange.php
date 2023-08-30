<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

readonly class NeedFileChange
{
    public function __construct(
        #[Description('Relative path to file')]
        public string $file,
        #[Description('Check contains string')]
        public ?string $contains,
        #[Description('Check contains by regex')]
        public ?string $containsRegex,
        #[Description('Check contains updated PHP constant')]
        public ?string $updatedPhpConstant,
    ) {
        //
    }

    public function hasConditions(): bool
    {
        return $this->contains !== null || $this->containsRegex !== null || $this->updatedPhpConstant !== null;
    }
}
