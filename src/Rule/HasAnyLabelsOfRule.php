<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * Merge Request must have any {labels}.
 */
class HasAnyLabelsOfRule extends AbstractLabelsRule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/has_any_labels_of';

    public function lint(MergeRequest $request): array
    {
        return $this->labels->diff($request->labels)->equalsCount($this->labels) ? $this->definitionToNotes() : [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("Merge Request must have any labels of: [". $this->labels->implode(', ') . "]");
    }
}
