<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\Report\Counter;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Value\NullCounter;

class ConditionRule implements RuleDecorator
{
    public function __construct(
        private Rule $rule,
        private ConditionOperator $operator,
        private readonly Counter $skippedRules = new NullCounter(),
    ) {
        //
    }

    public function getName(): string
    {
        return $this->rule->getName();
    }

    public function lint(MergeRequest $request): array
    {
        if (! $this->operator->check($request)) {
            $this->skippedRules->inc();

            return [];
        }

        return $this->rule->lint($request);
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->rule->getDefinition();
    }

    public function getDecoratedRules(): array
    {
        return [$this->rule];
    }
}
