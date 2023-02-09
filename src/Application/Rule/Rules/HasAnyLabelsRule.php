<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Merge Request must have any labels.
 */
class HasAnyLabelsRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/has_any_labels';

    protected function doLint(MergeRequest $request): bool
    {
        return ! $request->labels->isEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("Merge Request must have any labels");
    }
}
