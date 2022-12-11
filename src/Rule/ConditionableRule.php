<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class ConditionableRule implements Rule
{
    /**
     * @param iterable<ConditionOperator> $operators
     */
    public function __construct(
        private Rule $rule,
        private iterable $operators,
    ) {
        //
    }

    public static function getName(): string
    {
        return 'c';
    }

    public function lint(MergeRequest $request): array
    {
        if (! $this->evaluate($request)) {
            return [];
        }

        return $this->rule->lint($request);
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->rule->getDefinition();
    }

    private function evaluate(MergeRequest $request): bool
    {
        foreach ($this->operators as $operator) {
            if (! $operator->evaluate($request)) {
                return false;
            }
        }

        return true;
    }
}
