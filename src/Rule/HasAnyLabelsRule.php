<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

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
