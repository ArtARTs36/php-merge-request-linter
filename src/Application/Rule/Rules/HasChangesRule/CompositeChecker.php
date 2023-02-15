<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Request\Change;

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

    public function check(NeedFileChange $needChange, Change $change): array
    {
        $notes = [];

        foreach ($this->checkers as $checker) {
            array_push($notes, ...$checker->check($needChange, $change));
        }

        return $notes;
    }
}
