<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class ExceptionRule implements Rule
{
    public function __construct(
        private readonly string $exception,
    ) {
        //
    }

    public function getName(): string
    {
        return 'exception_rule';
    }

    public function lint(MergeRequest $request): array
    {
        throw new \Exception($this->exception);
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Exception Rule');
    }
}
