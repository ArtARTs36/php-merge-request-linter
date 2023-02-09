<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * @deprecated
 * The title must match the expression: {regex}
 */
class TitleMatchesExpressionRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/title_matches_expression';

    public function __construct(protected string $regex)
    {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->title->match($this->regex)->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('The title must match the expression: ' . $this->regex);
    }
}
