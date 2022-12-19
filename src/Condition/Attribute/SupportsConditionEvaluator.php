<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Attribute;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionEvaluator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class SupportsConditionEvaluator
{
    /**
     * @param array<class-string<ConditionEvaluator>> $operators
     */
    public function __construct(
        public array $operators,
    ) {
        //
    }
}
