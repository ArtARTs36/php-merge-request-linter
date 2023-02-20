<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\ToolInfo;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockGithubClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ToolInfoTest extends TestCase
{
    public function providerForUsedAsPhar(): array
    {
        return [
            [
                'phar://path/script.php',
                true,
            ],
            [
                '/path/script.php',
                false,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo::usedAsPhar
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo::__construct
     * @dataProvider providerForUsedAsPhar
     */
    public function testUsedAsPhar(string $dir, bool $expected): void
    {
        $info = new ToolInfo(new MockGithubClient(), $dir);

        self::assertEquals($expected, $info->usedAsPhar());
    }

    public function providerForTestGetLatestVersion(): array
    {
        return [
            'test with tag' => [
                'clientParams' => [
                    'tags' => [$expected1 = new Tag('1.0.0', 1, 0, 0)],
                ],
                'expected' => $expected1,
            ],
            'test without tag' => [
                'clientParams' => [],
                'expected' => null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo::getLatestVersion
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo::__construct
     * @dataProvider providerForTestGetLatestVersion
     */
    public function testGetLatestVersion(array $clientParams, ?Tag $expected): void
    {
        $client = new MockGithubClient(...$clientParams);
        $info = new ToolInfo($client);

        self::assertEquals($expected, $info->getLatestVersion());
    }
}
