<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check count changed files on a {limit}.
 */
class ChangedFilesLimitRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/changed_files_limit';

    public function __construct(protected int $limit)
    {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->changedFilesCount <= $this->limit;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("The merge request must contain no more than $this->limit changes.");
    }
}
