<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

/**
 * Title must starts with task number of project {projectName}. Mask: {projectName}-number
 */
class TitleStartsWithTaskNumberRule extends AbstractRule
{
    public const NAME = '@mr-linter/title_starts_with_task_number';

    public function __construct(
        private readonly string $projectName,
    ) {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->title->match("/^$this->projectName-\d+/")->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf('Title must starts with task number of project "%s"', $this->projectName));
    }
}
