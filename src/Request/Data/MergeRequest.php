<?php

namespace ArtARTs36\MergeRequestLinter\Request\Data;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsAnyOfOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\ContainsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\CountMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\CountMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EndsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\EqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\GteOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\HasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMaxOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\LteOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\NotEqualsOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\NotHasOperator;
use ArtARTs36\MergeRequestLinter\Condition\Operator\StartsOperator;
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
            EqualsOperator::class,
            LengthMinOperator::class,
            LengthMaxOperator::class,
            StartsOperator::class,
            EndsOperator::class,
            ContainsOperator::class,
            NotEqualsOperator::class,
            EqualsAnyOfOperator::class,
        ])]
        public Str $title,
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
        public Str $description,
        #[Generic(Generic::OF_STRING)]
        #[SupportsConditionOperator([
            CountMinOperator::class,
            CountMaxOperator::class,
            HasOperator::class,
            NotHasOperator::class,
        ])]
        public Set $labels,
        #[SupportsConditionOperator([
            EqualsOperator::class,
            NotEqualsOperator::class,
        ])]
        public bool $hasConflicts,
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
        public Str $sourceBranch,
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
        public Str $targetBranch,
        #[SupportsConditionOperator([
            EqualsOperator::class,
            LteOperator::class,
            GteOperator::class,
            NotEqualsOperator::class,
            EqualsAnyOfOperator::class,
        ])]
        public int $changedFilesCount,
        public Author $author,
        #[SupportsConditionOperator([
            EqualsOperator::class,
            NotEqualsOperator::class,
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
