<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions;

use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

final class ConditionEvaluatorNotFound extends MergeRequestLinterException
{
    public static function make(string $operator): self
    {
        return new self(sprintf('Condition Operator with name "%s" not found', $operator));
    }
}
