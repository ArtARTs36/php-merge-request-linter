<?php

namespace ArtARTs36\MergeRequestLinter\CI\System;

use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;
use ArtARTs36\MergeRequestLinter\Support\Http\URI;
use Psr\Http\Message\ResponseInterface;

trait InteractsWithResponse
{
    /**
     * @throws InvalidCredentialsException
     * @throws \RuntimeException
     */
    protected function validateResponse(ResponseInterface $response, string $url): void
    {
        $host = URI::host($url);

        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            throw InvalidCredentialsException::fromResponse($host, $response->getBody()->getContents());
        } elseif ($response->getStatusCode() !== 200) {
            throw ServerUnexpectedResponseException::create(
                $host,
                $response->getStatusCode(),
                $response->getBody()->getContents()
            );
        }
    }

    /**
     * @return array<mixed>
     */
    protected function responseToJsonArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
