<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class ConditionableRule implements Rule
{
    public function __construct(
        private Rule $rule,
        private ConditionOperator $operator,
    ) {
        //
    }

    public static function getName(): string
    {
        return 'c';
    }

    public function lint(MergeRequest $request): array
    {
        if (! $this->operator->evaluate($request)) {
            return [];
        }

        return $this->rule->lint($request);
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->rule->getDefinition();
    }
}