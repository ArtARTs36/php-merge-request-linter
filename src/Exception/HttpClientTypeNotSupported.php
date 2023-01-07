<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class HttpClientTypeNotSupported extends MergeRequestLinterException
{
    public static function make(string $type): self
    {
        return new self(sprintf('HTTP Client with type "%s" not supported', $type));
    }
}
