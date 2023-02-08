<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

final class DefaultEvaluators
{
    /** @var array<string, class-string<Evaluator>> */
    public static array $map = [
        EqualsEvaluator::NAME => EqualsEvaluator::class,
        EqualsEvaluator::SYMBOL => EqualsEvaluator::class,
        StartsEvaluator::NAME => StartsEvaluator::class,
        NotStartsOperator::NAME => NotStartsOperator::class,
        HasEvaluator::NAME => HasEvaluator::class,
        EndsEvaluator::NAME => EndsEvaluator::class,
        NotEndsEvaluator::NAME => NotEndsEvaluator::class,
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
        CountEqualsEvaluator::NAME => CountEqualsEvaluator::class,
        CountNotEqualsEvaluator::NAME => CountNotEqualsEvaluator::class,
        CountEqualsAnyEvaluator::NAME => CountEqualsAnyEvaluator::class,
    ];

    /**
     * @return ArrayMap<string, class-string<Evaluator>>
     */
    public static function map(): ArrayMap
    {
        return new ArrayMap(self::$map);
    }

    private function __construct()
    {
        //
    }
}
