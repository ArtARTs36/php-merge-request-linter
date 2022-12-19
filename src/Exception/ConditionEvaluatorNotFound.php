<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class ConditionEvaluatorNotFound extends MergeRequestLinterException
{
    public static function make(string $operator): self
    {
        return new self(sprintf('Condition Operator with name "%s" not found', $operator));
    }
}
