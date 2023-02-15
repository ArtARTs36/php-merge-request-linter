<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class SymfonyYamlDecoderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::decode
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::__construct
     */
    public function testDecode(): void
    {
        $decoder = new SymfonyYamlDecoder();

        self::assertEquals([1, 2, 3], $decoder->decode('
- 1
- 2
- 3
'));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::decode
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::__construct
     */
    public function testDecodeOnInvalidYamlString(): void
    {
        $decoder = new SymfonyYamlDecoder();

        self::expectExceptionMessage('Invalid yaml string');

        $decoder->decode('');
    }

    public function providerForTestDecodeOnParseException(): array
    {
        return [
            [
                '- e
a',
                'Unable to parse at line 2 (near "a").',
            ]
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::decode
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\SymfonyYamlDecoder::__construct
     * @dataProvider providerForTestDecodeOnParseException
     */
    public function testDecodeOnParseException(string $yaml, string $expectedExceptionMessage): void
    {
        $decoder = new SymfonyYamlDecoder();

        self::expectExceptionMessage($expectedExceptionMessage);

        $decoder->decode($yaml);
    }
}
