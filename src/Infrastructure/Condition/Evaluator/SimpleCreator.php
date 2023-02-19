<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

final class SimpleCreator implements EvaluatorCreator
{
    /**
     * @param Map<string, class-string<ConditionEvaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly Map $evaluatorByType,
    ) {
        //
    }

    public function create(string $type, mixed $value): ?ConditionEvaluator
    {
        $class = $this->evaluatorByType->get($type);

        if ($class === null) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return new $class($value);
    }
}
