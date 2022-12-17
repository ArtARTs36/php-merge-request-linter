<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Support\Reflector;

class OperatorMetadataLoader
{
    /**
     * @return array<class-string<ConditionOperator>, OperatorMetadata>>
     */
    public function load(): array
    {
        /** @var array<class-string<ConditionOperator>, OperatorMetadata> $operators */
        $operators = [];

        foreach (DefaultOperators::MAP as $operatorClass) {
            $operatorReflector = new \ReflectionClass($operatorClass);

            $param = Reflector::findParamByName($operatorReflector->getConstructor(), 'value');

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
                $operatorClass::NAME,
                $operatorClass,
                Reflector::hasAttribute($operatorReflector, EvaluatesSameType::class),
                Reflector::hasAttribute($operatorReflector, EvaluatesGenericType::class),
                $paramTypeNames,
            );
        }

        return $operators;
    }
}
