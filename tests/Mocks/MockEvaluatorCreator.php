<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\EvaluatorCreator;

final class MockEvaluatorCreator implements EvaluatorCreator
{
    public function __construct(
        private readonly ?ConditionEvaluator $evaluator = null,
    ) {
        //
    }

    public function create(string $type, mixed $value): ?ConditionEvaluator
    {
        return $this->evaluator;
    }
}
