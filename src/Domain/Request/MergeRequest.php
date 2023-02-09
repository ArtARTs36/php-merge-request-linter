<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;

class MergeRequest
{
    public const FIELDS = [
        'title',
        'description',
        'labels',
        'hasConflicts',
        'sourceBranch',
        'targetBranch',
        'author',
        'author.login',
        'isDraft',
        'canMerge',
        'changes',
    ];

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
