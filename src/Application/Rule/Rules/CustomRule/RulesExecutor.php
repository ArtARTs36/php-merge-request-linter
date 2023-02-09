<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;

use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for executing custom rules.
 * @phpstan-type MergeRequestField value-of<\ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest::FIELDS>
 * @phpstan-type EvaluatorName string
 * @phpstan-type ConditionValue mixed
 * @phpstan-type Condition array<EvaluatorName, ConditionValue>
 */
interface RulesExecutor
{
    /**
     * Execute user custom rules.
     * @param array<MergeRequestField, Condition> $rules
     */
    public function execute(array $rules, MergeRequest $request): bool;
}
