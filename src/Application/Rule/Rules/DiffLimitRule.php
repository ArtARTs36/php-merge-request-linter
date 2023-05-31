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
        private readonly int $linesMax,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $count = 0;

        foreach ($request->changes as $change) {
            $count += $change->diff->changesCount();

            if ($count >= $this->linesMax) {
                return [
                    new LintNote(sprintf(
                        'Your request contains too many changes. The request must contain no more than %s changes.',
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
