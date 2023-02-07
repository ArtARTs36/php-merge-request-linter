<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Interface for executing custom rules.
 */
interface RulesExecutor
{
    /**
     * Execute user custom rules.
     * @param array<string, array<string, mixed>> $rules
     */
    public function execute(array $rules, MergeRequest $request): bool;
}
