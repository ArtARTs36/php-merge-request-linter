<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpRequestException extends MergeRequestLinterException implements RequestException
{
    final public function __construct(
        private readonly RequestInterface $request,
        private readonly ?ResponseInterface $response = null,
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function create(RequestInterface $request, ResponseInterface $response): static
    {
        return new static(
            $request,
            $response,
            sprintf('%s returns response with status %d', $request->getUri()->getHost(), $response->getStatusCode()),
        );
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
