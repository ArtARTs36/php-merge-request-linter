<?php

namespace ArtARTs36\MergeRequestLinter\Linter\Event;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\LintEventSubscriber;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

class NullLintEventSubscriber implements LintEventSubscriber
{
    public function success(string $ruleName): void
    {
        //
    }

    public function fail(string $ruleName): void
    {
        //
    }

    public function stopOn(string $ruleName): void
    {
        //
    }

    public function started(MergeRequest $request): void
    {
        //
    }
}
