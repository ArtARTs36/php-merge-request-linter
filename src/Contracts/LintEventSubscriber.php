<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Subscriber for events from Linter.
 */
interface LintEventSubscriber
{
    /**
     * Emit 'success' event
     */
    public function success(string $ruleName): void;

    /**
     * Emit 'fail' event.
     */
    public function fail(string $ruleName): void;

    /**
     * Emit 'stopOn' event.
     */
    public function stopOn(string $ruleName): void;

    /**
     * Emit 'started linter' event.
     */
    public function started(MergeRequest $request): void;
}
