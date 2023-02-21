<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;

final class MockOperatorResolver implements OperatorResolver
{
    public function __construct(
        private readonly ?ConditionOperator $operator = null,
    ) {
        //
    }

    public function resolve(array $when): ConditionOperator
    {
        return $this->operator;
    }
}
