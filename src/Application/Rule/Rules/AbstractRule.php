<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

abstract class AbstractRule implements Rule
{
    public const NAME = '@mr-linter/abstract_rule';

    abstract protected function doLint(MergeRequest $request): bool;

    public function getName(): string
    {
        return static::NAME;
    }

    public function lint(MergeRequest $request): array
    {
        return $this->doLint($request) ? [] : [new LintNote($this->getDefinition()->getDescription())];
    }
}
