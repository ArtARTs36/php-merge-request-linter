<?php

namespace ArtARTs36\MergeRequestLinter\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Contracts\Report\Reporter;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

final class NullReporter implements Reporter
{
    public function report(LintResult $result, Arrayee $records): void
    {
        //
    }
}
