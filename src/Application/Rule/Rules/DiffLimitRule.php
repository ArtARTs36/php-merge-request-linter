<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

/**
 * The request must contain no more than {linesMax} changes.
 */
final class DiffLimitRule extends NamedRule
{
    public const NAME = '@mr-linter/diff_limit';

    public function __construct(
        private readonly ?int $linesMax,
        private readonly ?int $fileLinesMax,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $count = 0;

        foreach ($request->changes as $change) {
            $changesCount = $change->diff->changesCount();
            $count += $changesCount;

            if ($this->fileLinesMax !== null && $changesCount >= $this->fileLinesMax) {
                return [
                    new LintNote(sprintf(
                        'Your request contains too many changes. The changed file (%s) must contain no more than %d changes.',
                        $change->file,
                        $this->linesMax,
                    )),
                ];
            }

            if ($this->linesMax !== null && $count >= $this->linesMax) {
                return [
                    new LintNote(sprintf(
                        'Your request contains too many changes. The request must contain no more than %d changes.',
                        $this->linesMax,
                    )),
                ];
            }
        }

        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'The request must contain no more than %s changes.',
            $this->linesMax,
        ));
    }
}
