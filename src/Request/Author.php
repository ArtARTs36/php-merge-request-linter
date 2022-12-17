<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EndsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMinOperator;
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
        ])]
        public string $login,
    ) {
        //
    }
}
