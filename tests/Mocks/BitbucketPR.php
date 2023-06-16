<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequestState;
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
                $values['diff_url'] ?? '',
            $values['changes'] ?? new ArrayMap([]),
        );
    }
}
