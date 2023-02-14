<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Value;

use ArtARTs36\FileSystem\Arrays\ArrayFileSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class FileTransformerTest extends TestCase
{
    public function providerForTestTransform(): array
    {
        return [
            [
                [
                    '/var/web/file.txt' => 'content',
                ],
                'file(/var/web/file.txt)',
                'content',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::transform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::doTransform
     * @dataProvider providerForTestTransform
     */
    public function testTransform(array $files, string $value, string $expected): void
    {
        $fs = new ArrayFileSystem();

        foreach ($files as $filePath => $fileContent) {
            $fs->createFile($filePath, $fileContent);
        }

        $transformer = new FileTransformer($fs);

        self::assertEquals($expected, $transformer->transform($value));
    }
}
