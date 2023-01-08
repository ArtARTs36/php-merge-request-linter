<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMinEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\GteEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LteEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotHasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\StartsEvaluator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;

class MergeRequest
{
    /**
     * @param Set<string> $labels
     * @param Arrayee<int, string> $changeFiles
     */
    public function __construct(
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsEvaluator::class,
            EndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public Str $title,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsEvaluator::class,
            EndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public Str $description,
        #[Generic(Generic::OF_STRING)]
        #[SupportsConditionEvaluator([
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            HasEvaluator::class,
            NotHasOperator::class,
            HasAnyEvaluator::class,
        ])]
        public Set $labels,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ])]
        public bool $hasConflicts,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsEvaluator::class,
            EndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public Str $sourceBranch,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsEvaluator::class,
            EndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public Str $targetBranch,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            LteEvaluator::class,
            GteEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public int $changedFilesCount,
        public Author $author,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ])]
        public bool $isDraft,
        #[SupportsConditionEvaluator([
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ])]
        public bool $canMerge,
        #[SupportsConditionEvaluator([
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            HasEvaluator::class,
            NotHasOperator::class,
            HasAnyEvaluator::class,
        ])]
        public Arrayee $changeFiles,
    ) {
        //
    }
}
