<?php

namespace ArtARTs36\MergeRequestLinter\Request;

use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
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
    ];

    /**
     * @param Set<string> $labels
     */
    public function __construct(
        public Str $title,
        public Str $description,
        public Set $labels,
        public bool $hasConflicts,
        public Str $sourceBranch,
        public Str $targetBranch,
        public int $changedFilesCount,
        public Author $author,
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
        );
    }
}
