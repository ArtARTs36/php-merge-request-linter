<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\Counter;
use ArtARTs36\MergeRequestLinter\Domain\Metrics\NullCounter;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

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
