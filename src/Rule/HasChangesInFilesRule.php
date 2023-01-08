<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Merge Request must have changes in {files}.
 */
class HasChangesInFilesRule extends AbstractRule
{
    public const NAME = '@mr-linter/has_changes_in_files';

    /**
     * @param Set<string> $files
     */
    public function __construct(
        private readonly Set $files,
    ) {
        //
    }

    /**
     * @param iterable<string> $files
     */
    public static function make(#[Generic(Generic::OF_STRING)] iterable $files): self
    {
        return new self(Set::fromList($files));
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->changeFiles->containsAll($this->files);
    }

    public function getDefinition(): RuleDefinition
    {
        if ($this->files->once()) {
            return new Definition(sprintf('Merge Request must have changes in file: %s', $this->files->first()));
        }

        return new Definition(sprintf('Merge Request must have changes in files: %s', $this->files));
    }
}
