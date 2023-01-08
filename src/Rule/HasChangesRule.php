<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Merge Request must have changes in {files}.
 */
class HasChangesRule implements Rule
{
    public const NAME = '@mr-linter/has_changes';

    /**
     * @param Arrayee<FileChange> $changes
     */
    public function __construct(
        private readonly Arrayee $changes,
    ) {
        //
    }

    /**
     * @param iterable<FileChange> $changes
     */
    public static function make(#[Generic(FileChange::class)] iterable $changes): self
    {
        return new self(new Arrayee($changes));
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->changes as $needChange) {
            $requestChange = $request->changeFiles->get($needChange->file);

            if ($requestChange === null) {
                $notes[] = new LintNote(
                    sprintf('Request must contain change in file: %s', $needChange->file),
                );
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        if ($this->changes->once()) {
            return new Definition(sprintf('Merge Request must have changes in file: %s', $this->changes->first()));
        }

        return new Definition(sprintf('Merge Request must have changes in files: %s', $this->changes));
    }
}
