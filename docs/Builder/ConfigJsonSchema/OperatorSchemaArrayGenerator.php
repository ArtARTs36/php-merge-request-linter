<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluateSameType;
use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Support\Reflector;
use ArtARTs36\Str\Str;

class OperatorSchemaArrayGenerator
{
    public function generate()
    {
        $reflector = new \ReflectionClass(MergeRequest::class);
        $opArray = [
            'properties' => [],
        ];

        $operatorParameterTypeMap = [];
        /** @var array<class-string<ConditionOperator>, bool> $genericOperators */
        $genericOperators = [];

        foreach (DefaultOperators::MAP as $operatorClass) {
            $operatorReflector = new \ReflectionClass($operatorClass);

            $operatorParameterTypeMap[$operatorClass] = [];

            $param = Reflector::findParamByName($operatorReflector->getConstructor(), 'value');

            if ($param === null || ! $param->hasType()) {
                continue;
            }

            $paramRawType = $param->getType();
            $paramTypes = $paramRawType instanceof \ReflectionUnionType ? $paramRawType->getTypes() : [$paramRawType];

            foreach ($paramTypes as $paramType) {
                $operatorParameterTypeMap[$operatorClass][] = $paramType->getName();
            }

            if (Reflector::hasAttribute($operatorReflector, EvaluateSameType::class)) {
                $genericOperators[$operatorClass] = true;
            }
        }

        foreach ($reflector->getProperties() as $property) {
            $opArray['properties'][$property->getName()] = [
                'type' => 'object',
                'properties' => [],
            ];

            foreach ($property->getAttributes(SupportsConditionOperator::class) as $attribute) {
                $operators = current($attribute->getArguments());

                foreach ($operators as $operatorClass) {
                    $operatorName = $operatorClass::NAME;

                    if (isset($genericOperators[$operatorClass])) {
                        $opArray['properties'][$property->getName()]['properties'][$operatorName] = [
                            'type' => $this->prepareTypeToPrimitive($property->getType()->getName()),
                        ];

                        continue;
                    }

                    $opParamTypes = $operatorParameterTypeMap[$operatorClass];

                    if (count($opParamTypes) === 1) {
                        $opArray['properties'][$property->getName()]['properties'][$operatorName] = [
                            'type' => $opParamTypes[0],
                        ];
                    } else {
                        $anyOf = [];

                        foreach ($opParamTypes as $pType) {
                            $anyOf[] = [
                                'type' => $pType,
                            ];
                        }

                        $opArray['properties'][$property->getName()]['properties'][$operatorName]['anyOf'] = $anyOf;
                    }
                }
            }
        }

        return $opArray;
    }

    private function prepareTypeToPrimitive(string $type): string
    {
        if ($type === Str::class) {
            return 'string';
        }

        return $type;
    }
}
