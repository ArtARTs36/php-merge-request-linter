<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule\RulesExecutor;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * @phpstan-import-type MergeRequestField from RulesExecutor
 * @phpstan-import-type EvaluatorName from RulesExecutor
 * @phpstan-import-type ConditionValue from RulesExecutor
 * @phpstan-import-type Condition from RulesExecutor
 */
#[Description('Custom Rule for Users.')]
final class CustomRule extends AbstractRule
{
    public const NAME = 'custom';

    /**
     * @param array<MergeRequestField, Condition> $rules
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
