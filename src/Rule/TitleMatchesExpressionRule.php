<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * Title must matches expression: {regex}
 */
class TitleMatchesExpressionRule implements Rule
{
    use DefinitionToNotes;

    public function __construct(protected string $regex)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        return $request->title->match($this->regex)->isNotEmpty() ? [] : $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Title must matches expression: ' . $this->regex);
    }
}
