<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class HasAnyLabelsRule implements Rule
{
    use DefinitionToNotes;

    public function lint(MergeRequest $request): array
    {
        return $request->labels->isEmpty() ? $this->definitionToNotes() : [];
    }

    public function getDefinition(): string
    {
        return "Merge Request must have any labels";
    }
}
