<?php

namespace ArtARTs36\MergeRequestLinter\Condition;

use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsAnyOfOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\CountMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\CountMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EndsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\GteOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\HasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LteOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\NotHasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\StartsOperator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

final class DefaultOperators
{
    public const MAP = [
        EqualsOperator::NAME => EqualsOperator::class,
        EqualsOperator::SYMBOL => EqualsOperator::class,
        StartsOperator::NAME => StartsOperator::class,
        HasOperator::NAME => HasOperator::class,
        EndsOperator::NAME => EndsOperator::class,
        GteOperator::NAME => GteOperator::class,
        GteOperator::SYMBOL => GteOperator::class,
        LteOperator::NAME => LteOperator::class,
        LteOperator::SYMBOL => LteOperator::class,
        CountMinOperator::NAME => CountMinOperator::class,
        CountMaxOperator::NAME => CountMaxOperator::class,
        LengthMinOperator::NAME => LengthMinOperator::class,
        LengthMaxOperator::NAME => LengthMaxOperator::class,
        ContainsOperator::NAME => ContainsOperator::class,
        NotEqualsOperator::NAME => NotEqualsOperator::class,
        NotEqualsOperator::SYMBOL => NotEqualsOperator::class,
        NotHasOperator::NAME => NotHasOperator::class,
        EqualsAnyOfOperator::NAME => EqualsAnyOfOperator::class,
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
