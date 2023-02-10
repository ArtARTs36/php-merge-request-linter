<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;

class PropertyNotExists extends MergeRequestLinterException
{
    public function __construct(
        string $message,
        private readonly string $propertyName,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function make(string $property): self
    {
        return new self(sprintf('Property "%s" not exists', $property), $property);
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}
