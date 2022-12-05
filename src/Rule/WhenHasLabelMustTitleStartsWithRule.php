<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Actions\DefinitionToNotes;

/**
 * When has label must title starts with {prefix}.
 */
class WhenHasLabelMustTitleStartsWithRule extends AbstractRule implements Rule
{
    use DefinitionToNotes;

    public const NAME = '@mr-linter/when_has_label_must_title_starts_with';

    public function __construct(protected string $label, protected string $titlePrefix)
    {
        //
    }

    public function lint(MergeRequest $request): array
    {
        if ($request->labels->missing($this->label) || $request->title->startsWith($this->titlePrefix)) {
            return [];
        }

        return $this->definitionToNotes();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition("When there is a label \"$this->label\", the title must start with \"$this->titlePrefix\"");
    }
}
