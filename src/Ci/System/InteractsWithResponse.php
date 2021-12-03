<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
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
            throw InvalidCredentialsException::fromCiName($ciName);
        } elseif ($response->getStatusCode() !== 200) {
            throw new \RuntimeException($ciName . ' returns response with code '. $response->getStatusCode());
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
