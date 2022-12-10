<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\LintEventSubscriber;

class NullLintEventSubscriber implements LintEventSubscriber
{
    public function success(string $ruleName): void
    {
        // TODO: Implement success() method.
    }

    public function fail(string $ruleName): void
    {
        // TODO: Implement fail() method.
    }

    public function stopOn(string $ruleName): void
    {
        // TODO: Implement stopOn() method.
    }
}
