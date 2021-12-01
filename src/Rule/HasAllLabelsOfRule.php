<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class HasAllLabelsOfRule extends AbstractLabelsRule
{
    use DefinitionToNotes;

    public function lint(MergeRequest $request): array
    {
        return $this->labels->diff($request->labels)->isEmpty() ? [] : $this->definitionToNotes();
    }

    public function getDefinition(): string
    {
        return "Merge Request must have any labels of: [". $this->labels->implode(', ') . "]";
    }
}
