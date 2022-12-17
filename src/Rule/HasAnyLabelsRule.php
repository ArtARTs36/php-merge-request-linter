<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * Merge Request must have any labels.
 */
class HasAnyLabelsRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/has_any_labels';

    public function lint(MergeRequest $request): array
    {
        return $request->labels->isEmpty() ? $this->definitionToNotes() : [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("Merge Request must have any labels");
    }
}
