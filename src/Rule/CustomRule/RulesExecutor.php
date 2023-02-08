<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Interface for executing custom rules.
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 */
interface RulesExecutor
{
    /**
     * Execute user custom rules.
     * @param array<EvaluatorName, ConditionValue> $rules
     */
    public function execute(array $rules, MergeRequest $request): bool;
}
