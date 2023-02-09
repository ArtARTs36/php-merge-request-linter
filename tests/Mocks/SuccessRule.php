<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

class SuccessRule implements Rule
{
    public function getName(): string
    {
        return 'success_rule';
    }

    public function lint(MergeRequest $request): array
    {
        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Success rule');
    }
}
