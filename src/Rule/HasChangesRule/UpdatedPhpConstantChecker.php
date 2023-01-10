<?php

namespace ArtARTs36\MergeRequestLinter\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\Data\Change;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;

class UpdatedPhpConstantChecker implements DiffChecker
{
    public function check(FileChange $needChange, Change $change): array
    {
        if ($needChange->updatedPhpConstant === null) {
            return [];
        }

        return $this->hasConst($change, $needChange->updatedPhpConstant) ?
            [] :
            [
                new LintNote(
                    sprintf('Request must contain change php constant "%s" in file: %s', $needChange->updatedPhpConstant, $needChange->file),
                ),
            ];
    }

    private function hasConst(Change $change, string $const): bool
    {
        return
            $change->diff->hasChangeByContentContainsByRegex($this->regexForConst($const)) ||
            $change->diff->hasChangeByContentContainsByRegex($this->regexForDefine($const));
    }

    private function regexForConst(string $const): string
    {
        return <<<REGEXP
/const (\s+)?$const(\s+)?=(.*)/
REGEXP;
    }

    private function regexForDefine(string $const): string
    {
        return <<<REGEXP
/define\(('|")$const('|")/
REGEXP;
    }
}
