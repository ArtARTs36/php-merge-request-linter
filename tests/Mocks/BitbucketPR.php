<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestState;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\Str\Str;

class BitbucketPR
{
    public static function create(...$values): PullRequest
    {
        return new PullRequest(
            $values['id'] ?? 1,
            $values['title'] ?? '',
            $values['authorNickname'] ?? '',
            $values['sourceBranch'] ?? '',
            $values['targetBranch'] ?? '',
            $values['created_at'] ?? new \DateTimeImmutable(),
            $values['uri'] ?? '',
            $values['description'] ?? Str::fromEmpty(),
            $values['state'] ?? PullRequestState::Open,
            $values['changes'] ?? new ArrayMap([]),
        );
    }
}
