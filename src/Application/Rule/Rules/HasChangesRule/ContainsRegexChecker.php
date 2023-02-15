<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;

class ContainsRegexChecker implements DiffChecker
{
    public function check(NeedFileChange $needChange, Change $change): array
    {
        if ($needChange->containsRegex === null) {
            return [];
        }

        $hasNeedChange = $change->diff->hasChangeByContentContainsByRegex($needChange->containsRegex);

        return $hasNeedChange ?
            [] :
            [
                new LintNote(
                    sprintf('Request must contain change by regex "%s" in file: %s', $needChange->containsRegex, $needChange->file),
                ),
            ];
    }
}
