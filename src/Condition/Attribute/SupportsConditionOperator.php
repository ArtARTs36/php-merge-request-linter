<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Attribute;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class SupportsConditionOperator
{
    /**
     * @param array<class-string<ConditionOperator>> $operators
     */
    public function __construct(
        public array $operators,
    ) {
        //
    }
}
