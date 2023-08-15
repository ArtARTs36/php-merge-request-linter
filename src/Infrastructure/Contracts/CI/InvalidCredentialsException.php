<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;
use Psr\Http\Client\ClientExceptionInterface;

final class InvalidCredentialsException extends MergeRequestLinterException implements ClientExceptionInterface
{
}
