<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionOperator;
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
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LteOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotHasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\StartsOperator;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;
use JetBrains\PhpStorm\ArrayShape;

class MergeRequest
{
    public const REQUIRED_FIELDS = [
        'title' => 'string',
        'description' => 'string',
        'labels' => 'array',
        'has_conflicts' => 'bool',
        'source_branch' => 'string',
        'target_branch' => 'string',
        'changed_files_count' => 'integer',
        'author_login' => 'string',
        'is_draft' => 'bool',
    ];

    /**
     * @param Set<string> $labels
     */
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
        public Str $title,
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
        public Str $description,
        #[Generic(Generic::OF_STRING)]
        #[SupportsConditionOperator([
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            HasEvaluator::class,
            NotHasOperator::class,
            HasAnyEvaluator::class,
        ])]
        public Set $labels,
        #[SupportsConditionOperator([
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ])]
        public bool $hasConflicts,
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
        public Str $sourceBranch,
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
        public Str $targetBranch,
        #[SupportsConditionOperator([
            EqualsEvaluator::class,
            LteOperator::class,
            GteEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
        ])]
        public int $changedFilesCount,
        public Author $author,
        #[SupportsConditionOperator([
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ])]
        public bool $isDraft,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $request
     */
    public static function fromArray(
        #[ArrayShape(self::REQUIRED_FIELDS)]
        array $request
    ): self {
        foreach (self::REQUIRED_FIELDS as $field => $_) {
            if (! array_key_exists($field, $request)) {
                throw new \InvalidArgumentException(sprintf('Given invalid Merge Request: %s', $field));
            }
        }

        return new self(
            Str::make($request['title']),
            Str::make($request['description']),
            Set::fromList($request['labels']),
            (bool) $request['has_conflicts'],
            Str::make($request['source_branch']),
            Str::make($request['target_branch']),
            (int) $request['changed_files_count'],
            new Author($request['author_login']),
            $request['is_draft'],
        );
    }
}
