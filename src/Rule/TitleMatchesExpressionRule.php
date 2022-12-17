<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * The title must match the expression: {regex}
 */
class TitleMatchesExpressionRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/title_matches_expression';

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
        return new Definition('The title must match the expression: ' . $this->regex);
    }
}
