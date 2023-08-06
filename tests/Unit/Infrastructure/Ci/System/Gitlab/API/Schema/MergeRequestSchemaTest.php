<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\MergeRequestSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class MergeRequestSchemaTest extends TestCase
{
    public function providerForTestCreateMergeRequestOnInvalid(): array
    {
        return [
            #0
            [
                [],
                'Key "id" not found in response',
            ],
            #1
            [
                [
                    'id' => 1,
                ],
                'Key "iid" not found in response',
            ],
            #2
            [
                [
                    'id' => 1,
                    'iid' => 1,
                ],
                'Key "title" not found in response',
            ],
            #3
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 1,
                ],
                'Value of key "title" has invalid type. Expected type: string',
            ],
            #4
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                ],
                'Key "description" not found in response',
            ],
            #5
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 1,
                ],
                'Value of key "description" has invalid type. Expected type: string',
            ],
            #6
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                ],
                'Key "labels" not found in response',
            ],
            #7
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => 1,
                ],
                'Value of key "labels" has invalid type. Expected type: array<string>',
            ],
            #8
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                ],
                'Key "has_conflicts" not found in response',
            ],
            #9
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => 1,
                ],
                'Value of key "has_conflicts" has invalid type. Expected type: bool',
            ],
            #10
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                ],
                'Key "source_branch" not found in response',
            ],
            #11
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 1,
                ],
                'Value of key "source_branch" has invalid type. Expected type: string',
            ],
            #12
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                ],
                'Key "target_branch" not found in response',
            ],
            #13
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 1,
                ],
                'Value of key "target_branch" has invalid type. Expected type: string',
            ],
            #13
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                ],
                'Key "author" not found in response',
            ],
            #14
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => 1,
                ],
                'Value of key "author" has invalid type. Expected type: array{username: string}',
            ],
            #15
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [],
                ],
                'Key "author.username" not found',
            ],
            #16
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 1,
                    ],
                ],
                'Value of key "author.username" has invalid type. Expected type: string',
            ],
            #17
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                ],
                'Key "merge_status" not found in response',
            ],
            #18
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => 1,
                ],
                'Value of key "merge_status" has invalid type. Expected type: string',
            ],
            #19
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => '',
                ],
                'Key "changes" not found in response',
            ],
            #20
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => '',
                    'changes' => 1,
                ],
                'Value of key "changes" has invalid type. Expected type: array',
            ],
            #21
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => '',
                    'changes' => [],
                ],
                'Key "created_at" not found in response',
            ],
            #22
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => '',
                    'changes' => [],
                    'created_at' => 1,
                ],
                'Value of key "created_at" has invalid type. Expected type: string',
            ],
            #23
            [
                [
                    'id' => 1,
                    'iid' => 1,
                    'title' => 'Test-title',
                    'description' => 'Test-description',
                    'labels' => [],
                    'has_conflicts' => false,
                    'source_branch' => 'test-branch',
                    'target_branch' => 'master',
                    'author' => [
                        'username' => 'author-name',
                    ],
                    'merge_status' => '',
                    'changes' => [],
                    'created_at' => '2022-02-02 0scs',
                ],
                'Value of key "created_at" has invalid type. Expected type: string of datetime',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\MergeRequestSchema::createMergeRequest
     * @dataProvider providerForTestCreateMergeRequestOnInvalid
     */
    public function testCreateMergeRequest(array $data, string $expectedException): void
    {
        $schema = new MergeRequestSchema();

        self::expectExceptionMessage($expectedException);

        $schema->createMergeRequest($data);
    }
}
