<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PullRequestTest extends TestCase
{
    public static function providerForTestHasConflicts(): array
    {
        return [
            [
                'mergeable' => '',
                'expected' => false,
            ],
            [
                'mergeable' => PullRequest::MERGEABLE_STATE_CONFLICTING,
                'expected' => true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest::hasConflicts
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest::__construct
     *
     * @dataProvider providerForTestHasConflicts
     */
    public function testHasConflicts(string $mergeable, bool $expected): void
    {
        $pr = new PullRequest(
            '',
            '',
            '',
            '',
            [],
            $mergeable,
            '',
            '',
            1,
            '',
            '',
            new \DateTimeImmutable(),
            '',
            new ArrayMap([]),
        );

        self::assertEquals($expected, $pr->hasConflicts());
    }

    public static function providerForTestCanMerge(): array
    {
        return [
            [
                'mergeable' => '',
                'expected' => false,
            ],
            [
                'mergeable' => PullRequest::MERGEABLE_STATE_MERGEABLE,
                'expected' => true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest::canMerge
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest::__construct
     *
     * @dataProvider providerForTestCanMerge
     */
    public function testCanMerge(string $mergeable, bool $expected): void
    {
        $pr = new PullRequest(
            '',
            '',
            '',
            '',
            [],
            $mergeable,
            '',
            '',
            1,
            '',
            '',
            new \DateTimeImmutable(),
            '',
            new ArrayMap([]),
        );

        self::assertEquals($expected, $pr->canMerge(), sprintf('PR mergeable: %s', $pr->mergeable));
    }
}
