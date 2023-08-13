<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\BadRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\ForbiddenException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpRequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\UnauthorizedException;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use Psr\Log\NullLogger;

final class ClientGuzzleWrapperTest extends TestCase
{
    public function providerForTestSendRequestOnStatusException(): array
    {
        return [
            [
                'httpStatus' => 400,
                'expectedExceptionClass' => BadRequestException::class,
            ],
            [
                'httpStatus' => 401,
                'expectedExceptionClass' => UnauthorizedException::class,
            ],
            [
                'httpStatus' => 403,
                'expectedExceptionClass' => ForbiddenException::class,
            ],
            [
                'httpStatus' => 404,
                'expectedExceptionClass' => NotFoundException::class,
            ],
            [
                'httpStatus' => 500,
                'expectedExceptionClass' => HttpRequestException::class,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper::sendRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper::__construct
     * @dataProvider providerForTestSendRequestOnStatusException
     */
    public function testSendRequestOnStatusException(int $httpStatus, string $expectedExceptionClass): void
    {
        $http = $this->createMock(Client::class);

        $http
            ->expects(new InvokedCount(1))
            ->method('send')
            ->willReturn(new Response($httpStatus));

        $wrapper = new ClientGuzzleWrapper($http, new NullLogger());

        self::expectException($expectedExceptionClass);

        $wrapper->sendRequest(new Request('GET', 'https://google.com'));
    }
}
