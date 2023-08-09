<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestException extends RequestExceptionInterface
{
    public function getResponse(): ?ResponseInterface;
}
