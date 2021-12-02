<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;

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
}
