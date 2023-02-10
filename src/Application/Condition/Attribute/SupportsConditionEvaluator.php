<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Attribute;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;

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
