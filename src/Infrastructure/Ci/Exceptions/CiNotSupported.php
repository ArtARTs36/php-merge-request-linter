<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions;

use ArtARTs36\MergeRequestLinter\Exception\MergeRequestLinterException;

class CiNotSupported extends MergeRequestLinterException
{
    public static function fromCiName(string $ciName): self
    {
        return new self('CI "' . $ciName . '" not supported');
    }
}
