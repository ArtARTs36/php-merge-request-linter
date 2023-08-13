<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Http;

use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
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
                'httpStatus' => 401,
            ],
            [
                'httpStatus' => 403,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper::sendRequest
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\ClientGuzzleWrapper::__construct
     * @dataProvider providerForTestSendRequestOnStatusException
     */
    public function testSendRequestOnStatusException(int $httpStatus): void
    {
        $http = $this->createMock(Client::class);

        $http
            ->expects(new InvokedCount(1))
            ->method('sendRequest')
            ->willReturn(new Response($httpStatus));

        $wrapper = new ClientGuzzleWrapper($http, new NullLogger());

        self::expectException(InvalidCredentialsException::class);

        $wrapper->sendRequest(new Request('GET', 'https://google.com'));
    }
}
