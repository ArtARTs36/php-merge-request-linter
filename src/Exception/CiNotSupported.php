<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class CiNotSupported extends MergeRequestLinterException
{
    public static function fromCiName(string $ciName): self
    {
        return new self('CI "' . $ciName . '" not supported');
    }
}
