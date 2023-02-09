<?php

namespace ArtARTs36\MergeRequestLinter\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;

class CompositeChecker implements DiffChecker
{
    /**
     * @param iterable<DiffChecker> $checkers
     */
    public function __construct(
        private readonly iterable $checkers,
    ) {
        //
    }

    public function check(FileChange $needChange, Change $change): array
    {
        $notes = [];

        foreach ($this->checkers as $checker) {
            array_push($notes, ...$checker->check($needChange, $change));
        }

        return $notes;
    }
}
