<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

final class DefaultEvaluators
{
    /** @var array<string, class-string<ConditionEvaluator>> */
    public const MAP = [
        EqualsEvaluator::NAME => EqualsEvaluator::class,
        EqualsEvaluator::SYMBOL => EqualsEvaluator::class,
        StartsEvaluator::NAME => StartsEvaluator::class,
        HasEvaluator::NAME => HasEvaluator::class,
        EndsEvaluator::NAME => EndsEvaluator::class,
        GteEvaluator::NAME => GteEvaluator::class,
        GteEvaluator::SYMBOL => GteEvaluator::class,
        LteEvaluator::NAME => LteEvaluator::class,
        LteEvaluator::SYMBOL => LteEvaluator::class,
        CountMinEvaluator::NAME => CountMinEvaluator::class,
        CountMaxEvaluator::NAME => CountMaxEvaluator::class,
        LengthMinOperator::NAME => LengthMinOperator::class,
        LengthMaxEvaluator::NAME => LengthMaxEvaluator::class,
        ContainsEvaluator::NAME => ContainsEvaluator::class,
        NotEqualsEvaluator::NAME => NotEqualsEvaluator::class,
        NotEqualsEvaluator::SYMBOL => NotEqualsEvaluator::class,
        NotHasOperator::NAME => NotHasOperator::class,
        EqualsAnyEvaluator::NAME => EqualsAnyEvaluator::class,
        HasAnyEvaluator::NAME => HasAnyEvaluator::class,
    ];

    /**
     * @return Map<string, class-string<ConditionEvaluator>>
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
