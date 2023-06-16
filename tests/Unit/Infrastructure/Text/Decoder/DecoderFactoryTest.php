<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecoderNotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DecoderFactoryTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            ['yaml', SymfonyYamlDecoder::class],
            ['json', NativeJsonProcessor::class],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory::create
     * @dataProvider providerForTestCreate
     */
    public function testCreate(string $format, string $expectedClass): void
    {
        $factory = new DecoderFactory();

        self::assertInstanceOf($expectedClass, $factory->create($format));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory::create
     */
    public function testCreateOnDecoderNotFound(): void
    {
        $factory = new DecoderFactory();

        self::expectException(TextDecoderNotFoundException::class);

        $factory->create('non-exists-decoder-format');
    }
}
