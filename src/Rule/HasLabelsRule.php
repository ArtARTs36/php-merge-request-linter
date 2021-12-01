<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class HasLabelsRule implements Rule
{
    use DefinitionToNotes;

    /**
     * @param array<string> $labels
     */
    public function __construct(protected array $labels)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        if ((count($this->labels) === 0 && $request->labels->isEmpty()) || $request->labels->isEmpty()) {
            return $this->definitionToNotes();
        }

        return [];
    }

    public function getDefinition(): string
    {
        return "Merge must have labels: [". implode(',', $this->labels) . "]";
    }
}
