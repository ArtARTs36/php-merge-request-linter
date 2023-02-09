<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\CustomRule\RulesExecutor;

/**
 * Custom Rule for Users.
 * @phpstan-import-type MergeRequestField from RulesExecutor
 * @phpstan-import-type EvaluatorName from RulesExecutor
 * @phpstan-import-type ConditionValue from RulesExecutor
 * @phpstan-import-type Condition from RulesExecutor
 */
class CustomRule extends AbstractRule
{
    public const NAME = 'custom';

    /**
     * @param array<array<MergeRequestField, Condition>> $rules
     */
    public function __construct(
        private readonly RulesExecutor $executor,
        private readonly array $rules,
        private readonly string $definition,
    ) {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $this->executor->execute($this->rules, $request);
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition($this->definition);
    }
}
