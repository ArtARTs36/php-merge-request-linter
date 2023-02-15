<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\File;

use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DirectoryTest extends TestCase
{
    public function providerForTestPathTo(): array
    {
        return [
            [
                '/var/web',
                'file.txt',
                '/var/web/file.txt',
            ],
            [
                '/var/web/',
                'file.txt',
                '/var/web/file.txt',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\Directory::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\Directory::pathTo
     * @dataProvider providerForTestPathTo
     */
    public function testPathTo(string $dir, string $file, string $expected): void
    {
        $directory = new Directory($dir);

        self::assertEquals($expected, $directory->pathTo($file));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\Directory::__toString
     */
    public function testToString(): void
    {
        $directory = new Directory('/var/web');

        self::assertEquals('/var/web', (string) $directory);
    }
}
