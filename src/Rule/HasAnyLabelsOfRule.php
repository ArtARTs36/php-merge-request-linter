<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;
use ArtARTs36\MergeRequestLinter\Support\Map;

class HasAnyLabelsOfRule implements Rule
{
    use DefinitionToNotes;

    public function __construct(protected Map $labels)
    {
        //
    }

    /**
     * @param array<string> $labels
     */
    public static function make(array $labels): self
    {
        return new self(Map::fromList($labels));
    }

    public function lint(MergeRequest $request): array
    {
        return $this->labels->diff($request->labels)->equalsCount($this->labels) ? $this->definitionToNotes() : [];
    }

    public function getDefinition(): string
    {
        return "Merge Request must have any labels of: [". $this->labels->implode(', ') . "]";
    }
}
