<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Definition;

use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

class Definition implements RuleDefinition
{
    public function __construct(protected string $description)
    {
        //
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}
