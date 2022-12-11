<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Support\Map;

final class DefaultOperators
{
    public const MAP = [
        EqualsOperator::NAME => EqualsOperator::class,
        StartsOperator::NAME => StartsOperator::class,
        ContainsOperator::NAME => ContainsOperator::class,
        EndsOperator::NAME => EndsOperator::class,
        GteOperator::NAME => GteOperator::class,
        GteOperator::SYMBOL => GteOperator::class,
        LteOperator::NAME => LteOperator::class,
        LteOperator::SYMBOL => LteOperator::class,
    ];

    /**
     * @return Map<string, class-string<ConditionOperator>>
     */
    public static function map(): Map
    {
        return new Map(self::MAP);
    }

    private function __construct()
    {
        //
    }
}
