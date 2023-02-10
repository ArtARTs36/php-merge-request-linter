<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Application\Condition\Attribute\EvaluatesSameType;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\DefaultEvaluators;
use ArtARTs36\MergeRequestLinter\Common\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Common\Reflector\Reflector;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;

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

        foreach (DefaultEvaluators::map()->groupKeysByValue() as $operatorClass => $operatorNames) {
            $operatorReflector = new \ReflectionClass($operatorClass);

            $param = Reflector::findParamByName($operatorReflector->getConstructor(), self::OPERATOR_VALUE_FIELD);

            if ($param === null || ! $param->hasType()) {
                continue;
            }

            $paramRawType = $param->getType();
            $paramTypes = $paramRawType instanceof \ReflectionUnionType ? $paramRawType->getTypes() : [$paramRawType];

            /** @var array<Parameter> $paramTypeNames */
            $paramTypeNames = [];

            $genericAttr = $param->getAttributes(Generic::class);
            $genericAttrFirst = current($genericAttr);

            $genericType = null;

            if ($genericAttrFirst !== false) {
                $genericType = current($genericAttrFirst->getArguments());
            }

            foreach ($paramTypes as $paramType) {
                $paramTypeNames[] = new Parameter(
                    $paramType->getName(),
                    JsonType::to($paramType->getName()),
                    $genericType,
                );
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
