<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

interface LintEventSubscriber
{
    public function success(string $ruleName): void;

    public function fail(string $ruleName): void;

    public function stopOn(string $ruleName): void;
}
