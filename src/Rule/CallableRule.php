<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class CallableRule implements Rule
{
    use DefinitionToNotes;

    public function __construct(protected \Closure $callback, protected string $definition)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $callback = $this->callback;
        $result = $callback($request);

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
