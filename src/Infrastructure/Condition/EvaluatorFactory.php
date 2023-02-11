<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Iter\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\ConditionEvaluatorNotFound;

/**
 * @phpstan-type EvaluatorName string
 */
class EvaluatorFactory
{
    /**
     * @param ArrayMap<EvaluatorName, class-string<ConditionEvaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly ArrayMap $evaluatorByType,
    ) {
        //
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    public function create(string $type, mixed $value): ConditionEvaluator
    {
        if ($type === AllEvaluator::NAME && is_array($value)) {
            return $this->createAllEvaluator($value);
        } elseif ($type === AnyEvaluator::NAME && is_array($value)) {
            return $this->createAnyEvaluator($value);
        }

        return $this->createByType($type, $value);
    }

    /**
     * @param EvaluatorName $type
     * @throws ConditionEvaluatorNotFound
     */
    private function createByType(string $type, mixed $value): ConditionEvaluator
    {
        $class = $this->evaluatorByType->get($type);

        if ($class === null) {
            throw ConditionEvaluatorNotFound::make($type);
        }

        return new $class($value);
    }

    /**
     * @param array<EvaluatorName, mixed> $value
     */
    private function createAllEvaluator(array $value): ConditionEvaluator
    {
        $evaluators = [];

        foreach ($value as $evName => $val) {
            $evaluators[] = $this->create($evName, $val);
        }

        return new AllEvaluator($evaluators);
    }

    /**
     * @param array<EvaluatorName, mixed> $value
     */
    private function createAnyEvaluator(array $value): ConditionEvaluator
    {
        $evaluators = [];

        foreach ($value as $evName => $val) {
            $evaluators[] = $this->create($evName, $val);
        }

        return new AnyEvaluator($evaluators);
    }
}
