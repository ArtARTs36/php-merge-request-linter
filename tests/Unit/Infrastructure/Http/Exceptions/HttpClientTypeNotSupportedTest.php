<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpClientTypeNotSupported;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HttpClientTypeNotSupportedTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpClientTypeNotSupported::make
     */
    public function testMake(): void
    {
        $e = HttpClientTypeNotSupported::make('super-http-client');

        self::assertEquals('HTTP Client with type "super-http-client" not supported', $e->getMessage());
    }
}
