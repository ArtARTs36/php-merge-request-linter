<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class WhenHasLabelMustTitleStartsWithRule implements Rule
{
    use DefinitionToNotes;

    public function __construct(protected string $label, protected string $titlePrefix)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        if ($request->labels->missing($this->label) || $request->title->startsWith($this->titlePrefix)) {
            return [];
        }

        return $this->definitionToNotes();
    }

    public function getDefinition(): string
    {
        return "When there is a label \"$this->label\", the title must start with \"$this->titlePrefix\"";
    }
}
