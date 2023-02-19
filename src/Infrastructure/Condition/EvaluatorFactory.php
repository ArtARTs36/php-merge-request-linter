<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\EvaluatorCreator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

/**
 * @phpstan-type EvaluatorName string
 */
class EvaluatorFactory
{
    public function __construct(
        private readonly EvaluatorCreator $creator,
    ) {
        //
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, mixed $value): ConditionEvaluator
    {
        $evaluator = $this->creator->create($type, $value);

        if ($evaluator === null) {
            throw new \RuntimeException(sprintf('Evaluator with name "%s" not resolved', $type));
        }

        return $evaluator;
    }
}
