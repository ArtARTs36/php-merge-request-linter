<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator\EvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

/**
 * @phpstan-import-type EvaluatorName from EvaluatorCreator
 */
class EvaluatorFactory
{
    public function __construct(
        private readonly EvaluatorCreator $creator,
    ) {
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, mixed $value): ConditionEvaluator
    {
        $evaluator = $this->creator->create($type, $value);

        if ($evaluator === null) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return $evaluator;
    }
}
