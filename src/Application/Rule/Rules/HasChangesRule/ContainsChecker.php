<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;

class ContainsChecker implements DiffChecker
{
    public function check(NeedFileChange $needChange, Change $change): array
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
