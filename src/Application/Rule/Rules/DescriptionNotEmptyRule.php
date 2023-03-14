<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

/**
 * The description must be filled.
 */
final class DescriptionNotEmptyRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/description_not_empty';

    protected function doLint(MergeRequest $request): bool
    {
        return $request->description->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('The description must be filled');
    }
}
