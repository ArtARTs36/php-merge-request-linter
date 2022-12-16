<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Condition\DefaultOperators;
use ArtARTs36\MergeRequestLinter\Support\Reflector;

class OperatorSchemaArrayGenerator
{
    public function generate()
    {
        $reflector = new \ReflectionClass(MergeRequest::class);
        $opArray = [
            'properties' => [],
        ];

        $operatorParameterTypeMap = [];

        foreach (DefaultOperators::MAP as $operatorClass) {
            $operatorParameterTypeMap[$operatorClass] = [];

            $param = Reflector::findParamByName((new \ReflectionClass($operatorClass))->getConstructor(), 'value');

            if ($param === null || ! $param->hasType()) {
                continue;
            }

            $paramRawType = $param->getType();
            $paramTypes = $paramRawType instanceof \ReflectionUnionType ? $paramRawType->getTypes() : [$paramRawType];

            foreach ($paramTypes as $paramType) {
                $operatorParameterTypeMap[$operatorClass][] = $paramType->getName();
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
}
