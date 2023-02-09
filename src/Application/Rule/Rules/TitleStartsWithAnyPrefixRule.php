<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * The title must starts with any {prefixes}
 */
class TitleStartsWithAnyPrefixRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/title_must_starts_with_any_prefix';

    /**
     * @param array<string> $prefixes
     */
    public function __construct(protected array $prefixes)
    {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request->title->startsWithAnyOf($this->prefixes);
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('The title must starts with any prefix of: [' . implode(',', $this->prefixes) . ']');
    }
}
