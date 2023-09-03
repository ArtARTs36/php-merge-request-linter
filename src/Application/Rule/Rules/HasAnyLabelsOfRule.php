<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

#[Description('Merge Request must have any {labels}.')]
final class HasAnyLabelsOfRule extends AbstractLabelsRule
{
    public const NAME = '@mr-linter/has_any_labels_of';

    protected function doLint(MergeRequest $request): bool
    {
        return ! $this->labels->diff($request->labels)->equalsCount($this->labels);
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'Merge Request must have any labels of: [%s]',
            $this->labels->implode(', '),
        ));
    }
}
