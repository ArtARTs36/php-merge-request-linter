<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;

/**
 * Forbid changes for files.
 */
class ForbidChangesRule extends NamedRule
{
    public const NAME = '@mr-linter/forbid_changes';

    /**
     * @param Set<string> $files
     */
    public function __construct(
        #[Description('A set of files forbidden to be changed.')]
        #[Generic(Generic::OF_STRING)]
        private readonly Set $files,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->files as $file) {
            if ($request->changes->has($file)) {
                $notes[] = new LintNote(sprintf(
                    'Changes forbidden in file: %s',
                    $file,
                ));
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        if ($this->files->once()) {
            $definition = sprintf('Changes forbidden in file "%s"', $this->files->first());
        } else {
            $definition = sprintf('Changes forbidden in files: [%s]', $this->files->implode(', '));
        }

        return new Definition($definition);
    }
}
