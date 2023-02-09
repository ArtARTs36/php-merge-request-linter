<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountEqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountNotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMinEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotHasEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotStartsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\StartsEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;

class MergeRequest
{
    /**
     * @param Set<string> $labels
     * @param Map<string, Change> $changes
     */
    public function __construct(
        public Str $title,
        public Str $description,
        #[Generic(Generic::OF_STRING)]
        public Set $labels,
        public bool $hasConflicts,
        public Str $sourceBranch,
        public Str $targetBranch,
        public Author $author,
        public bool $isDraft,
        public bool $canMerge,
        #[Generic(Change::class)]
        public Map  $changes,
    ) {
        //
    }
}
