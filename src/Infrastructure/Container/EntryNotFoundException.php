<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Container;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;
use Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundException extends MergeRequestLinterException implements NotFoundExceptionInterface
{
    public static function create(string $id): self
    {
        return new self(
            sprintf('Object of class "%s" not found', $id),
        );
    }
}
