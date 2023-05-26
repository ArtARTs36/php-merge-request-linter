<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class WarningRule implements Rule
{
    public function __construct(
        private readonly string $note,
    ) {
        //
    }

    public function getName(): string
    {
        return 'warning_rule';
    }

    public function lint(MergeRequest $request): array
    {
        return [
            new WarningNote($this->note),
        ];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('warning');
    }
}
