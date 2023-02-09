<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;

/**
 * Interface for checking Merge Request Diff.
 */
interface DiffChecker
{
    /**
     * Check Diff.
     * @return array<LintNote>
     */
    public function check(NeedFileChange $needChange, Change $change): array;
}
