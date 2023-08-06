<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;

/**
 * @phpstan-type FileName string
 * @codeCoverageIgnore
 */
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
     * @param Map<FileName, Change> $changes
     */
    public function __construct(
        public Str $title,
        public Markdown $descriptionMarkdown,
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
        public \DateTimeImmutable $createdAt,
        public Str $uri,
        public string $id = '',
        public string $number = '',
    ) {
        //
    }
}
