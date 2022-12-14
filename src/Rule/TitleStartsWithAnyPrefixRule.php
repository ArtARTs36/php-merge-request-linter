<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * The title must starts with any {prefixes}
 */
class TitleStartsWithAnyPrefixRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/title_must_starts_with_any_prefix';

    /**
     * @param array<string> $prefixes
     */
    public function __construct(protected array $prefixes)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        return $request->title->startsWithAnyOf($this->prefixes) ? [] : $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('The title must starts with any prefix of: [' . implode(',', $this->prefixes) . ']');
    }
}
