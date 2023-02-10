<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

/**
 * Merge Request must have all {labels}
 */
class HasAllLabelsOfRule extends AbstractLabelsRule
{
    public const NAME = '@mr-linter/has_all_labels';

    protected function doLint(MergeRequest $request): bool
    {
        return $this->labels->diff($request->labels)->isEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("Merge Request must have all labels of: [". $this->labels->implode(', ') . "]");
    }
}
