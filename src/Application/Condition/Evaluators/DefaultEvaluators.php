<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMinEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountNotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\IsEmptyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsCamelCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsKebabCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsLowerCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsSnakeCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsStudlyCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsUpperCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsLineEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotEndsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\StartsEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

/**
 * @codeCoverageIgnore
 */
final class DefaultEvaluators
{
    /** @var array<string, class-string<ConditionEvaluator>> */
    public static array $map = [
        EqualsEvaluator::NAME => EqualsEvaluator::class,
        EqualsEvaluator::SYMBOL => EqualsEvaluator::class,
        StartsEvaluator::NAME => StartsEvaluator::class,
        NotStartsEvaluator::NAME => NotStartsEvaluator::class,
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
        NotHasEvaluator::NAME => NotHasEvaluator::class,
        EqualsAnyEvaluator::NAME => EqualsAnyEvaluator::class,
        HasAnyEvaluator::NAME => HasAnyEvaluator::class,
        CountEqualsEvaluator::NAME => CountEqualsEvaluator::class,
        CountNotEqualsEvaluator::NAME => CountNotEqualsEvaluator::class,
        CountEqualsAnyEvaluator::NAME => CountEqualsAnyEvaluator::class,
        MatchEvaluator::NAME => MatchEvaluator::class,
        IsEmptyEvaluator::NAME => IsEmptyEvaluator::class,
        IsCamelCaseEvaluator::NAME => IsCamelCaseEvaluator::class,
        IsStudlyCaseEvaluator::NAME => IsStudlyCaseEvaluator::class,
        IsLowerCaseEvaluator::NAME => IsLowerCaseEvaluator::class,
        IsUpperCaseEvaluator::NAME => IsUpperCaseEvaluator::class,
        IsSnakeCaseEvaluator::NAME => IsSnakeCaseEvaluator::class,
        IsKebabCaseEvaluator::NAME => IsKebabCaseEvaluator::class,
        AllEvaluator::NAME => AllEvaluator::class,
        AnyEvaluator::NAME => AnyEvaluator::class,
        LinesMaxEvaluator::NAME => LinesMaxEvaluator::class,
        ContainsLineEvaluator::NAME => ContainsLineEvaluator::class,
    ];

    /**
     * @return Map<string, class-string<ConditionEvaluator>>
     */
    public static function map(): Map
    {
        return new ArrayMap(self::$map);
    }

    private function __construct()
    {
        //
    }
}
