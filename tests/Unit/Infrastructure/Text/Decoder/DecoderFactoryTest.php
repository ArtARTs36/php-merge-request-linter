<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DecoderFactoryTest extends TestCase
{
    public function providerForTestFactory(): array
    {
        return [
            ['yaml', SymfonyYamlDecoder::class],
            ['json', NativeJsonDecoder::class],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\DecoderFactory::create
     * @dataProvider providerForTestFactory
     */
    public function testFactory(string $format, string $expectedClass): void
    {
        $factory = new DecoderFactory();

        self::assertInstanceOf($expectedClass, $factory->create($format));
    }
}
