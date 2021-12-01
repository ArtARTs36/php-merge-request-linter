<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Actions;

use ArtARTs36\MergeRequestLinter\Note\LintNote;

trait DefinitionToNotes
{
    abstract public function getDefinition(): string;

    /**
     * @return LintNote[]
     */
    protected function definitionToNotes(): array
    {
        return [new LintNote($this->getDefinition())];
    }
}
