<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema::createPullRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema::getInt
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema::getString
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema::__construct
     * @dataProvider providerForCreatePullRequestFailed
     */
    public function testCreatePullRequestFailed(array $data, string $exception): void
    {
        $schema = new PullRequestSchema(LocalClock::utc());

        self::expectExceptionMessage($exception);

        $schema->createPullRequest($data);
    }
}
