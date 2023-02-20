<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class InvalidCredentialsExceptionTest extends TestCase
{
    public function providerForTestFromResponse(): array
    {
        return [
            [
                'site.ru',
                '{}',
                'Given invalid credentials for site.ru. Server returns: "{}"',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException::fromResponse
     * @dataProvider providerForTestFromResponse
     */
    public function testFromResponse(string $host, string $response, string $expected): void
    {
        self::assertEquals($expected, InvalidCredentialsException::fromResponse($host, $response)->getMessage());
    }
}
