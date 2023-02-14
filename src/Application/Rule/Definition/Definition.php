<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Definition;

use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class Definition implements RuleDefinition
{
    public function __construct(
        private readonly string $description,
    ) {
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
