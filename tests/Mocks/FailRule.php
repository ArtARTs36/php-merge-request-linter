<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class FailRule implements Rule
{
    public function getName(): string
    {
        return 'fail_rule';
    }

    public function lint(MergeRequest $request): array
    {
        return [new EmptyNote()];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('');
    }
}
