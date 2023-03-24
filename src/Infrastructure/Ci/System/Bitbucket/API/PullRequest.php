<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\Normalizer\Value\Selectors\Key;
use ArtARTs36\Str\Facade\Str;

class PullRequest
{
    /**
     * @param Map<string, array<DiffLine>> $changes
     */
    public function __construct(
        public readonly int                $id,
        public readonly string             $title,
        #[Key('author.nickname')]
        public readonly string             $authorNickname,
        #[Key('source.branch.name')]
        public readonly string             $sourceBranch,
        #[Key('destination.branch.name')]
        public readonly string             $targetBranch,
        #[Key('created_on')]
        public readonly \DateTimeImmutable $createdAt,
        #[Key('links.html.href')]
        public readonly string             $uri,
        public readonly \ArtARTs36\Str\Str             $description,
        public readonly PullRequestState  $state,
        public Map                $changes,
        #[Key('links.diff.href')]
        public readonly ?string $diffUrl,
    ) {
        //
    }

    public function canMerge(): bool
    {
        return $this->state === PullRequestState::Open;
    }

    public function isDraft(): bool
    {
        return Str::startsWith($this->title, 'Draft:');
    }
}
