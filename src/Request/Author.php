<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\EndsOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Rule\Condition\StartsOperator;

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
