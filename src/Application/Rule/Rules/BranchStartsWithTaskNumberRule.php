<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;

/**
 * Source branch must starts with task number of project {projectName}. Mask: {projectName}-number
 */
final class BranchStartsWithTaskNumberRule extends AbstractRule
{
    public const NAME = '@mr-linter/branch_starts_with_task_number';

    public function __construct(
        #[Example('VIP')]
        private readonly string $projectName,
    ) {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->sourceBranch->match("/^$this->projectName-\d+/")->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf('Source branch must starts with task number of project "%s"', $this->projectName));
    }
}
