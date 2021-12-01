<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

abstract class SimpleRule implements Rule
{
    use DefinitionToNotes;

    /**
     * @return bool|array<Note>
     */
    abstract protected function doLint(MergeRequest $request): bool|array;

    public function __construct(protected string $definition)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $result = $this->doLint($request);

        if (is_array($result)) {
            return $result;
        }

        if ($result === false) {
            return $this->definitionToNotes();
        }

        return [];
    }

    public function getDefinition(): string
    {
        return $this->definition;
    }
}
