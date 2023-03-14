<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestState;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\BitbucketPR;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PullRequestTest extends TestCase
{
    public function providerForTestCanMerge(): array
    {
        return [
            [
                BitbucketPR::create(
                    state: PullRequestState::Open,
                ),
                true,
            ],
            [
                BitbucketPR::create(
                    state: PullRequestState::Declined,
                ),
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest::canMerge
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest::__construct
     * @dataProvider providerForTestCanMerge
     */
    public function testCanMerge(PullRequest $pr, bool $expected): void
    {
        self::assertEquals($expected, $pr->canMerge());
    }

    public function providerForTestIsDraft(): array
    {
        return [
            [
                BitbucketPR::create(
                    title: 'Draft: PR',
                ),
                true,
            ],
            [
                BitbucketPR::create(
                    title: 'PR',
                ),
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest::isDraft
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest::__construct
     * @dataProvider providerForTestIsDraft
     */
    public function testIsDraft(PullRequest $pr, bool $expected): void
    {
        self::assertEquals($expected, $pr->isDraft());
    }
}
