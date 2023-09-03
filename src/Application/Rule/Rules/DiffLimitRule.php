<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

#[Description('The request must contain no more than {linesMax} changes.')]
final class DiffLimitRule extends NamedRule
{
    public const NAME = '@mr-linter/diff_limit';

    public function __construct(
        #[Description('Maximum allowed number of changed lines')]
        private readonly ?int $linesMax,
        #[Description('Maximum allowed number of changed lines in a file')]
        private readonly ?int $fileLinesMax,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $count = 0;
        $notes = [];
        $linesMaxExceeded = false;

        foreach ($request->changes as $change) {
            $fileLinesCount = $change->diff->changesCount();
            $count += $fileLinesCount;

            if ($this->fileLinesMax !== null && $fileLinesCount >= $this->fileLinesMax) {
                $notes[] = $this->createNoteFileLinesLimitExceeded($change);
            }

            if (! $linesMaxExceeded && $this->linesMax !== null && $count >= $this->linesMax) {
                if ($this->fileLinesMax === null) {
                    return [$this->createNoteLinesMaxLimitExceeded()];
                }

                $notes[] = $this->createNoteLinesMaxLimitExceeded();
                $linesMaxExceeded = true;
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        $definition = [];

        if ($this->linesMax !== null) {
            $definition[] = sprintf('The request must contain no more than %d changes.', $this->linesMax);
        }

        if ($this->fileLinesMax !== null) {
            $definition[] = sprintf(
                'The request must contain no more than %d changes in a file.',
                $this->fileLinesMax,
            );
        }

        return new Definition(implode(' ', $definition));
    }

    private function createNoteFileLinesLimitExceeded(Change $change): Note
    {
        return new LintNote(sprintf(
            'Your request contains too many changes. The changed file "%s" must contain no more than %d changes.',
            $change->file,
            $this->fileLinesMax,
        ));
    }

    private function createNoteLinesMaxLimitExceeded(): Note
    {
        return new LintNote(sprintf(
            'Your request contains too many changes. The request must contain no more than %d changes.',
            $this->linesMax,
        ));
    }
}
