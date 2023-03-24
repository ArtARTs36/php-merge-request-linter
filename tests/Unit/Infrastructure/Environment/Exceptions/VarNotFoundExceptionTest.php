<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Environment\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class VarNotFoundExceptionTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException::make
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException::__construct
     */
    public function testMake(): void
    {
        $e = VarNotFoundException::make('APP_DEBUG');

        self::assertEquals(
            'Environment variable with name \'APP_DEBUG\' not found',
            $e->getMessage(),
        );
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException::getVarName
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Exceptions\VarNotFoundException::__construct
     */
    public function testGetVarName(): void
    {
        $e = VarNotFoundException::make('APP_DEBUG');

        self::assertEquals('APP_DEBUG', $e->getVarName());
    }
}
