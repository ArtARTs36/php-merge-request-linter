<?php

namespace ArtARTs36\MergeRequestLinter\Application\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

interface Reporter
{
    public function report(MergeRequest $request, LintResult $result): void;
}
