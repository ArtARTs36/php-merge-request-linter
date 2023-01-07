<?php

namespace ArtARTs36\MergeRequestLinter\CI\System;

use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Exception\ServerUnexpectedResponseException;
use Psr\Http\Message\ResponseInterface;

trait InteractsWithResponse
{
    /**
     * @throws InvalidCredentialsException
     * @throws \RuntimeException
     */
    protected function validateResponse(ResponseInterface $response, string $ciName): void
    {
        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {
            throw InvalidCredentialsException::fromResponse($ciName, $response->getBody()->getContents());
        } elseif ($response->getStatusCode() !== 200) {
            throw ServerUnexpectedResponseException::create(
                $ciName,
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
