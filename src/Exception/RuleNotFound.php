<?php

namespace ArtARTs36\MergeRequestLinter\Exception;

class RuleNotFound extends MergeRequestLinterException
{
    public static function fromRuleName(string $ruleName): self
    {
        return new self(sprintf('Rule with name %s not found', $ruleName));
    }
}
