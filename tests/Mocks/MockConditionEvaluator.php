<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

final class MockConditionEvaluator implements ConditionEvaluator
{
    public function __construct(
        private readonly bool $value,
    ) {
        //
    }

    public function evaluate(EvaluatingSubject $subject): bool
    {
        return $this->value;
    }
}
