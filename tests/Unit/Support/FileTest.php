<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Support;

use ArtARTs36\MergeRequestLinter\Support\File\File;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class FileTest extends TestCase
{
    public function providerForTestExtension(): array
    {
        return [
            [
                '/var/folder/file.ext',
                'ext',
            ],
            [
                '/var/folder/file.EXT',
                'ext',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Support\File\File::extension
     * @dataProvider providerForTestExtension
     */
    public function testExtension(string $path, string $expected): void
    {
        self::assertEquals($expected, File::extension($path));
    }
}
