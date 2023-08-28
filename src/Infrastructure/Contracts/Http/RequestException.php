<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for RequestException.
 */
interface RequestException extends RequestExceptionInterface
{
    /**
     * Get response.
     */
    public function getResponse(): ?ResponseInterface;
}
