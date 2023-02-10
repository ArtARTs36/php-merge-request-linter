<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class EvaluatorFactory
{
    /**
     * @param ArrayMap<string, class-string<Evaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly ArrayMap $evaluatorByType,
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
