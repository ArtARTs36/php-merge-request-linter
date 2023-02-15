<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\File;

use ArtARTs36\MergeRequestLinter\Shared\File\File;
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
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\File::extension
     * @dataProvider providerForTestExtension
     */
    public function testExtension(string $path, string $expected): void
    {
        self::assertEquals($expected, File::extension($path));
    }

    public function providerForTestGetSizeString(): array
    {
        return [
            [
                __DIR__ . '/test_file.txt',
                '13 bytes',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\File::getSizeString
     * @dataProvider providerForTestGetSizeString
     */
    public function testGetSizeString(string $path, string $size): void
    {
        self::assertEquals($size, (new File($path))->getSizeString());
    }
}
