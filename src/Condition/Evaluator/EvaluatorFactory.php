<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Exception\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class EvaluatorFactory
{
    /**
     * @param Map<string, class-string<Evaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly Map $evaluatorByType,
    ) {
        //
    }

    /**
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, mixed $value): ConditionEvaluator
    {
        $class = $this->evaluatorByType->get($type);

        if ($class === null) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return new $class($value);
    }
}
