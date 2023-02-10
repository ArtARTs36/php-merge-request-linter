<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions;

use ArtARTs36\MergeRequestLinter\Common\Exceptions\MergeRequestLinterException;

class RuleNotFound extends MergeRequestLinterException
{
    public static function fromRuleName(string $ruleName): self
    {
        return new self(sprintf('Rule with name %s not found', $ruleName));
    }
}
