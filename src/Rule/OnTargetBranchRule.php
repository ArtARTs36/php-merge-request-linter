<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Apply another rule if the target branch equals {targetBranch}.
 */
class OnTargetBranchRule implements Rule
{
    /**
     * @var \ArtARTs36\MergeRequestLinter\Contracts\Rule[]
     */
    protected array $decorateRules;

    /**
     * @param array<Rule>|Rule $decorateRule
     */
    public function __construct(protected string $targetBranch, array|Rule $decorateRule)
    {
        $this->decorateRules = is_array($decorateRule) ? $decorateRule : [$decorateRule];
    }

    public function lint(MergeRequest $request): array
    {
        return $request->targetBranch->equals($this->targetBranch) ? $this->runLintOnDecorateRules($request) : [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Apply another rule if the target branch equals: ' . $this->targetBranch);
    }

    /**
     * @return array<Note>
     */
    protected function runLintOnDecorateRules(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->decorateRules as $rule) {
            $notes[] = $rule->lint($request);
        }

        return array_filter($notes);
    }
}
