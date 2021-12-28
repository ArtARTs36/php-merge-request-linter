<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * Check count changed files on a {limit}.
 */
class ChangedFilesLimitRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    public function __construct(protected int $limit)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        return $request->changedFilesCount > $this->limit ? $this->definitionToNotes() : [];
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->createDefinition("The merge request must contain no more than $this->limit changes.");
    }
}
