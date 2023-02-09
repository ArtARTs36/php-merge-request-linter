<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use Psr\Http\Message\ResponseInterface;

trait InteractsWithResponse
{
    /**
     * @return array<mixed>
     */
    protected function responseToJsonArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}