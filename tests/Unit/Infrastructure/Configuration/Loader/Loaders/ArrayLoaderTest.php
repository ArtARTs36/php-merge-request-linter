<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\FileSystem\Arrays\ArrayFileSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecodingException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class ArrayLoaderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader::load
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader::__construct
     */
    public function testLoadOnFileNotFound(): void
    {
        $decoder = $this->createMock(TextDecoder::class);

        $hydrator = $this->createMock(ArrayConfigHydrator::class);

        $loader = new ArrayLoader(new ArrayFileSystem(), $decoder, $hydrator);

        self::expectException(ConfigNotFound::class);

        $loader->load('config.yaml');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader::load
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders\ArrayLoader::__construct
     */
    public function testLoadOnDecodingFailedException(): void
    {
        $decoder = $this->createMock(TextDecoder::class);
        $decoder
            ->expects(new InvokedCount(1))
            ->method('decode')
            ->willThrowException(new TextDecodingException());

        $fs = new ArrayFileSystem();
        $fs->createFile('config.yaml', '');

        $hydrator = $this->createMock(ArrayConfigHydrator::class);

        $loader = new ArrayLoader($fs, $decoder, $hydrator);

        self::expectException(ConfigInvalidException::class);

        $loader->load('config.yaml');
    }
}
