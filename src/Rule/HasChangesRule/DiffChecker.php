<?php

namespace ArtARTs36\MergeRequestLinter\Rule\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Rule\FileChange;

/**
 * Interface for checking Merge Request Diff.
 */
interface DiffChecker
{
    /**
     * Check Diff.
     * @return array<LintNote>
     */
    public function check(FileChange $needChange, Change $change): array;
}
