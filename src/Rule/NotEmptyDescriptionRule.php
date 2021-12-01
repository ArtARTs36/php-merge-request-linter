<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class NotEmptyDescriptionRule implements Rule
{
    use DefinitionToNotes;

    public function lint(MergeRequest $request): array
    {
        $errors = [];

        if ($request->description->isEmpty()) {
            $errors[] = $this->definitionToNotes();
        }

        return $errors;
    }

    public function getDefinition(): string
    {
        return 'Description must filled';
    }
}
