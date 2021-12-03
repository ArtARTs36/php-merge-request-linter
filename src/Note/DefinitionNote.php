<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;

class DefinitionNote extends AbstractNote
{
    public function __construct(protected RuleDefinition $definition)
    {
        //
    }

    public function getDescription(): string
    {
        return $this->definition->getDescription();
    }
}
