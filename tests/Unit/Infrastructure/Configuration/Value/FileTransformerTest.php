<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Value;

use ArtARTs36\FileSystem\Arrays\ArrayFileSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\InvalidConfigValueException;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::__construct
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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::transform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::doTransform
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\FileTransformer::__construct
     */
    public function testTransformOnNonExistsFile(): void
    {
        $fs = new ArrayFileSystem();

        $transformer = new FileTransformer($fs);

        self::expectException(InvalidConfigValueException::class);

        $transformer->transform('file(file.txt)');
    }
}
