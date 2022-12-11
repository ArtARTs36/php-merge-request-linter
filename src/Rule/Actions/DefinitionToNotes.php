<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Actions;

use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Note\LintNote;

trait DefinitionToNotes
{
    abstract public function getDefinition(): RuleDefinition;

    /**
     * @return LintNote[]
     */
    protected function definitionToNotes(): array
    {
        return [new LintNote($this->getDefinition()->getDescription())];
    }
}
