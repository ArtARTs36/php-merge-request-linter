<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Environment\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class VarHasDifferentTypeExceptionTest extends TestCase
{
    public function providerForTestMake(): array
    {
        return [
            [
                'VAR1',
                'string',
                'int',
                'Environment variable "VAR1" has type: "int", expected type "string"',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarHasDifferentTypeException::make
     * @dataProvider providerForTestMake
     */
    public function testMake(string $var, string $expectedType, string $realType, string $expectedMessage): void
    {
        $e = VarHasDifferentTypeException::make($var, $expectedType, $realType);

        self::assertEquals($expectedMessage, $e->getMessage());
    }
}
