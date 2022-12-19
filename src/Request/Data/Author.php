<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\StartsOperator;

class Author
{
    public function __construct(
        #[SupportsConditionOperator([
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsOperator::class,
            EndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public string $login,
    ) {
        //
    }
}
