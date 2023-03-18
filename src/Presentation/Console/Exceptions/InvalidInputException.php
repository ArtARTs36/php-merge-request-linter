<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;
use Symfony\Component\Console\Exception\ExceptionInterface;

class InvalidInputException extends MergeRequestLinterException implements ExceptionInterface
{
    //
}
