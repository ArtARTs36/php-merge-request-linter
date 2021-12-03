<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Actions;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Note\DefinitionNote;

trait DefinitionToNotes
{
    abstract public function getDefinition(): RuleDefinition;

    /**
     * @return DefinitionNote[]
     */
    protected function definitionToNotes(): array
    {
        return [new DefinitionNote($this->getDefinition())];
    }
}
