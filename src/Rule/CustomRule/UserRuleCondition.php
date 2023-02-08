<?php

namespace ArtARTs36\MergeRequestLinter\Rule\CustomRule;

class UserRuleCondition
{
    public function __construct(
        public readonly string $evaluator,
        public readonly mixed $value,
    ) {
        //
    }
}
