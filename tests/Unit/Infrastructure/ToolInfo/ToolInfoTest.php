<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\ToolInfo;

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
}
