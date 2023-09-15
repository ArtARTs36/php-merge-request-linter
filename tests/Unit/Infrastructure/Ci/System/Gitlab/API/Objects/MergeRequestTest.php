<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\API\Objects;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MergeRequestTest extends TestCase
{
    public static function providerForTestCanMerge(): array
    {
        return [
            [
                'requestData' => [
                    'id' => 1,
                    'number' => 2,
                    'title' => '',
                    'description' => '',
                    'labels' => [],
                    'hasConflicts' => false,
                    'sourceBranch' => '',
                    'targetBranch' => '',
                    'authorLogin' => '',
                    'isDraft' => false,
                    'mergeStatus' => '',
                    'changes' => [],
                    'createdAt' => new \DateTimeImmutable(),
                    'uri' => '',
                ],
                false,
            ],
            [
                'requestData' => [
                    'id' => 1,
                    'number' => 2,
                    'title' => '',
                    'description' => '',
                    'labels' => [],
                    'hasConflicts' => false,
                    'sourceBranch' => '',
                    'targetBranch' => '',
                    'authorLogin' => '',
                    'isDraft' => false,
                    'mergeStatus' => 'can_be_merged',
                    'changes' => [],
                    'createdAt' => new \DateTimeImmutable(),
                    'uri' => '',
                ],
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest::canMerge
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest::__construct
     *
     * @dataProvider providerForTestCanMerge
     */
    public function testCanMerge(array $requestData, bool $expected): void
    {
        $request = new MergeRequest(...$requestData);

        self::assertEquals($expected, $request->canMerge());
    }
}
