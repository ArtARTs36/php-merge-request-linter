<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PullRequestSchemaTest extends TestCase
{
    public function providerForCreatePullRequestFailed(): array
    {
        return [
            [
                [],
                'Key "id" not found in response',
            ],
            [
                [
                    'id' => 'str',
                ],
                'Value of key "id" has invalid type. Expected type: int',
            ],

            [
                [
                    'id' => 1,
                ],
                'Key "title" not found in response',
            ],
            [
                [
                    'id' => 1,
                    'title' => 1,
                ],
                'Value of key "title" has invalid type. Expected type: string',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestSchema::createPullRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestSchema::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequestSchema::getString
     * @dataProvider providerForCreatePullRequestFailed
     */
    public function testCreatePullRequestFailed(array $data, string $exception): void
    {
        $schema = new PullRequestSchema();

        self::expectExceptionMessage($exception);

        $schema->createPullRequest($data);
    }
}
