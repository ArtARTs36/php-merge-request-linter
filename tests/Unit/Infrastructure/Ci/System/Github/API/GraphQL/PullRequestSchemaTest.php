<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Shared\Time\LocalClock;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class PullRequestSchemaTest extends TestCase
{
    public function providerForTestCreatePullRequestOnInvalidData(): array
    {
        return [
            #0
            [
                [],
                'Key "data" not found in response',
            ],
            #1
            [
                [
                    'data' => [],
                ],
                'Key "data.repository" not found in response',
            ],
            #2
            [
                [
                    'data' => [
                        'repository' => [],
                    ],
                ],
                'Key "data.repository.pullRequest" not found in response',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema::createPullRequest
     * @dataProvider providerForTestCreatePullRequestOnInvalidData
     */
    public function testCreatePullRequestOnInvalidData(array $data, string $expectedException): void
    {
        $schema = new PullRequestSchema(LocalClock::utc());

        self::expectExceptionMessage($expectedException);

        $schema->createPullRequest($data);
    }
}
