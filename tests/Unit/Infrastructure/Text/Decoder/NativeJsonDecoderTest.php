<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor;
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
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor::decode
     * @dataProvider providerForTestDecode
     */
    public function testDecode(string $json, array $expected): void
    {
        $decoder = new NativeJsonProcessor();

        self::assertEquals($expected, $decoder->decode($json));
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor::decode
     */
    public function testDecodeOnJsonError(): void
    {
        self::expectExceptionMessage('json_decode error:');

        $decoder = new NativeJsonProcessor();

        $decoder->decode('');
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder\NativeJsonProcessor::decode
     */
    public function testDecodeOnJsonInvalid(): void
    {
        self::expectExceptionMessage('JSON content invalid');

        $decoder = new NativeJsonProcessor();

        $decoder->decode('null');
    }
}
