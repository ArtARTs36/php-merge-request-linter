<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Regex\ProjectCode;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * Source branch must starts with task number of project {projectCodes}. Mask: {projectCode}-number
 */
final class BranchStartsWithTaskNumberRule extends NamedRule
{
    public const NAME = '@mr-linter/branch_starts_with_task_number';

    public function __construct(
        #[Example('ABC')]
        #[Generic(Generic::OF_STRING)]
        #[Description('Project codes. Empty list allowed for any projects')]
        private readonly Arrayee $projectCodes = new Arrayee([]),
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $projectCode = ProjectCode::findInStartWithTaskNumber($request->sourceBranch);

        if ($projectCode === null) {
            return [
                new LintNote(sprintf(
                    'Branch must starts with task number of projects [%s]',
                    $this->projectCodes->implode(', '),
                )),
            ];
        }

        if (! $this->projectCodes->isEmpty() && ! $this->projectCodes->contains((string) $projectCode)) {
            return [
                new LintNote(sprintf(
                    'Branch must starts with task number of unknown project "%s"',
                    $projectCode,
                )),
            ];
        }

        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'Source branch must starts with task number of projects [%s]',
            $this->projectCodes->implode(', '),
        ));
    }
}
