<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;

/**
 * Disable adding files of certain extensions.
 */
final class DisableFileExtensionsRule extends NamedRule
{
    public const NAME = '@mr-linter/disable_file_extensions';

    /**
     * @param Set<string> $extensions
     */
    public function __construct(
        #[Example('pem')]
        #[Example('pub')]
        #[Example('php')]
        #[Generic(Generic::OF_STRING)]
        #[Description('array of file extensions')]
        private readonly Set $extensions,
    ) {
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($request->changes as $change) {
            $extension = $change->fileExtension();

            if ($this->extensions->contains($extension)) {
                $notes[] = new LintNote(sprintf(
                    'File "%s" has disabled extension "%s"',
                    $change->file,
                    $extension,
                ));
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'Merge request must no contain files with extensions: [%s]',
            $this->extensions->implode(', '),
        ));
    }
}
