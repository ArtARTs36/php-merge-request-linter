<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpRequestException extends \Exception implements RequestException
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ?ResponseInterface $response = null,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
