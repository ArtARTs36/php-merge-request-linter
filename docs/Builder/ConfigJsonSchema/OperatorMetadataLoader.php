<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

class OperatorMetadataLoader
{
    private const OPERATOR_VALUE_FIELD = 'value';

    /**
     * @return array<class-string<ConditionOperator>, OperatorMetadata>>
     */
    public function load(): array
    {
        /** @var array<class-string<ConditionOperator>, OperatorMetadata> $operators */
        $operators = [];

        foreach (DefaultOperators::map()->groupKeysByValue() as $operatorClass => $operatorNames) {
            $operatorReflector = new \ReflectionClass($operatorClass);

            $param = Reflector::findParamByName($operatorReflector->getConstructor(), self::OPERATOR_VALUE_FIELD);

            if ($param === null || ! $param->hasType()) {
                continue;
            }

            $paramRawType = $param->getType();
            $paramTypes = $paramRawType instanceof \ReflectionUnionType ? $paramRawType->getTypes() : [$paramRawType];

            /** @var array<string> $paramTypeNames */
            $paramTypeNames = [];

            foreach ($paramTypes as $paramType) {
                $paramTypeNames[] = JsonType::to($paramType->getName());
            }

            $operators[$operatorClass] = new OperatorMetadata(
                $operatorNames,
                $operatorClass,
                Reflector::hasAttribute($operatorReflector, EvaluatesSameType::class),
                Reflector::hasAttribute($operatorReflector, EvaluatesGenericType::class),
                $paramTypeNames,
                Reflector::findPHPDocSummary($operatorReflector) ?? '',
            );
        }

        return $operators;
    }
}
