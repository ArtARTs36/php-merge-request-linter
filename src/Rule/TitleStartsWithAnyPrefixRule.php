<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

class TitleStartsWithAnyPrefixRule implements Rule
{
    use DefinitionToNotes;

    /**
     * @param array<string> $prefixes
     */
    public function __construct(protected array $prefixes)
    {
        //
    }

    /**
     * @param array<string>|string $prefix
     */
    public static function make(array|string $prefix): self
    {
        return new self((array) $prefix);
    }

    public function lint(MergeRequest $request): array
    {
        $starts = false;

        foreach ($this->prefixes as $prefix) {
            if ($request->title->startsWith($prefix)) {
                $starts = true;

                break;
            }
        }

        return $starts ? [] : $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Title must starts with of one: [' . implode(',', $this->prefixes) . ']');
    }
}
