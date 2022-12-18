<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsAnyOfOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EndsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\StartsOperator;

class Author
{
    public function __construct(
        #[SupportsConditionOperator([
            EqualsOperator::class,
            LengthMinOperator::class,
            LengthMaxOperator::class,
            StartsOperator::class,
            EndsOperator::class,
            ContainsOperator::class,
            NotEqualsOperator::class,
            EqualsAnyOfOperator::class,
        ])]
        public string $login,
    ) {
        //
    }
}
