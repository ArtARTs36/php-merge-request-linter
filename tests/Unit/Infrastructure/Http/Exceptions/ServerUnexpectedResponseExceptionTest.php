<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ServerUnexpectedResponseException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class ServerUnexpectedResponseExceptionTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            [
                'host' => 'site.ru',
                'status' => 409,
                'response' => '{}',
                'expected' => 'site.ru returns response with code 409. Response: {}',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ServerUnexpectedResponseException::create
     * @dataProvider providerForTestCreate
     */
    public function testCreate(string $host, int $status, string $response, string $expected): void
    {
        self::assertEquals($expected, ServerUnexpectedResponseException::create($host, $status, $response)->getMessage());
    }
}
