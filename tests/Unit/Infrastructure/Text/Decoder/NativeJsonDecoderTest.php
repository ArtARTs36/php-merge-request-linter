<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NativeJsonDecoderTest extends TestCase
{
    public function providerForTestDecode(): array
    {
        return [
            [
                '{"key": "value"}',
                ['key' => 'value'],
            ]
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder::decode
     * @dataProvider providerForTestDecode
     */
    public function testDecode(string $json, array $expected): void
    {
        $decoder = new NativeJsonDecoder();

        self::assertEquals($expected, $decoder->decode($json));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonDecoder::decode
     */
    public function testDecodeOnJsonError(): void
    {
        self::expectExceptionMessage('json_decode error:');

        $decoder = new NativeJsonDecoder();

        $decoder->decode('');
    }
}
