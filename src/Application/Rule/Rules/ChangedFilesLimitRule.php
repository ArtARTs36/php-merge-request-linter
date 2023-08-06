<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * Check count changed files on a {limit}.
 */
final class ChangedFilesLimitRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/changed_files_limit';

    public function __construct(
        #[Description('Number of maximum possible changes')]
        private readonly int $limit,
    ) {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->changes->count() <= $this->limit;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("The merge request must contain no more than $this->limit changes.");
    }
}
