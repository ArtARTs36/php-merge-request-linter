<?php

namespace ArtARTs36\MergeRequestLinter\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\Data\Change;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;

class ContainsChecker implements DiffChecker
{
    public function check(FileChange $needChange, Change $change): array
    {
        if ($needChange->contains === null) {
            return [];
        }

        $hasNeedChange = $change->diff->hasChangeByContentContains($needChange->contains);

        return $hasNeedChange ?
            [] :
            [
                new LintNote(
                    sprintf('Request must contain change "%s" in file: %s', $needChange->contains, $needChange->file),
                ),
            ];
    }
}
