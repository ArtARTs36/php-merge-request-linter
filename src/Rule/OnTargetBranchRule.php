<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Apply another rule if the target branch equals {targetBranch}.
 */
class OnTargetBranchRule implements Rule
{
    public function __construct(protected string $targetBranch, protected Rule $decorateRule)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        return $request->targetBranch->equals($this->targetBranch) ?
            $this->decorateRule->lint($request) :
            [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Apply another rule if the target branch equals: ' . $this->targetBranch);
    }
}
