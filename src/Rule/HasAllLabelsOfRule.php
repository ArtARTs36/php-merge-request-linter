<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * Merge Request must have all {labels}
 */
class HasAllLabelsOfRule extends AbstractLabelsRule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/has_all_labels';

    public function lint(MergeRequest $request): array
    {
        return $this->labels->diff($request->labels)->isEmpty() ? [] : $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("Merge Request must have all labels of: [". $this->labels->implode(', ') . "]");
    }
}
