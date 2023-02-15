<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\File;

use ArtARTs36\MergeRequestLinter\Shared\File\Bytes;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BytesTest extends TestCase
{
    public function providerForTestToString(): array
    {
        return [
            [1023, '1023 bytes'],
            [1024, '1.00 KB'],
            [1025, '1.00 KB'],
            [1525, '1.49 KB'],
            [1048576, '1.00 MB'],
            [1048577, '1.00 MB'],
            [1059577, '1.01 MB'],
            [1073741824, '1.00 GB'],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\File\Bytes::toString
     * @dataProvider providerForTestToString
     */
    public function testToString(int $bytes, string $expected): void
    {
        self::assertEquals($expected, Bytes::toString($bytes));
    }
}
