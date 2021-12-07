<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Apply another rule if the target branch equals {targetBranch}.
 */
class OnTargetBranchRule extends AbstractDecorateRule
{
    /**
     * @param array<Rule>|Rule $decorateRule
     */
    public function __construct(protected string $targetBranch, array|Rule $decorateRule)
    {
        parent::__construct(is_array($decorateRule) ? $decorateRule : [$decorateRule]);
    }

    public function lint(MergeRequest $request): array
    {
        return $request->targetBranch->equals($this->targetBranch) ? $this->runLintOnDecorateRules($request) : [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Apply another rule if the target branch equals: ' . $this->targetBranch);
    }
}
