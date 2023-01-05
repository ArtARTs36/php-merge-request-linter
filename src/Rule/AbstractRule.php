<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

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
