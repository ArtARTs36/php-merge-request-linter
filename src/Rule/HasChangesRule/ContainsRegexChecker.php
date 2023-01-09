<?php

namespace ArtARTs36\MergeRequestLinter\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\Data\Change;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;

class ContainsRegexChecker implements DiffChecker
{
    public function check(FileChange $needChange, Change $change): array
    {
        if ($needChange->containsRegex === null) {
            return [];
        }

        $hasNeedChange = $change->diff->hasChangeByContentContains($needChange->containsRegex);

        return $hasNeedChange ?
            [] :
            [
                new LintNote(
                    sprintf('Request must contain change by regex "%s" in file: %s', $needChange->containsRegex, $needChange->file),
                ),
            ];
    }
}
