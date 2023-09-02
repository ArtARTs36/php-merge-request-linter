<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Regex\ProjectCode;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * Title must starts with task number of project {projectName}. Mask: {projectName}-number
 */
final class TitleStartsWithTaskNumberRule extends NamedRule
{
    public const NAME = '@mr-linter/title_starts_with_task_number';

    /**
     * @param Arrayee<int, string> $projectCodes
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        #[Description('Project codes. Empty list allowed for any projects')]
        private readonly Arrayee $projectCodes = new Arrayee([]),
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $projectCode = ProjectCode::findInStartWithTaskNumber($request->title);

        if ($projectCode === null) {
            return [
                new LintNote(sprintf(
                    'Description of title must starts with task number of projects [%s]',
                    $this->projectCodes->implode(', '),
                )),
            ];
        }

        if (! $this->projectCodes->isEmpty() && ! $this->projectCodes->contains((string) $projectCode)) {
            return [
                new LintNote(sprintf(
                    'Description of title must starts with task number of unknown project "%s"',
                    $projectCode,
                )),
            ];
        }

        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            sprintf('Title must starts with task number of projects ["%s"]', $this->projectCodes->implode(', ')),
        );
    }
}
