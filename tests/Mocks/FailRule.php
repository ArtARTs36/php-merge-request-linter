<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Definition;

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
