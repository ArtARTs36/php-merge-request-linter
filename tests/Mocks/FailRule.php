<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Definition;

final class FailRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        return [new EmptyNote()];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('');
    }
}
