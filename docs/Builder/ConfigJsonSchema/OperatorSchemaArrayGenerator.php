<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\SupportsConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;

class OperatorSchemaArrayGenerator
{
    public function __construct(
        private OperatorMetadataLoader $operatorMetadataLoader = new OperatorMetadataLoader(),
    ) {
        //
    }

    public function generate(): array
    {
        $reflector = new \ReflectionClass(MergeRequest::class);
        $opArray = [
            'properties' => [],
        ];

        $operatorMetadata = $this->operatorMetadataLoader->load();

        return $this->doGenerate($reflector, $operatorMetadata, $opArray, '');
    }

    /**
     * @param array<class-string<ConditionOperator>, OperatorMetadata> $operatorMetadata
     */
    private function doGenerate(\ReflectionClass $reflector, array $operatorMetadata, array $opArray, string $propertyPrefix): array
    {
        foreach ($reflector->getProperties() as $property) {
            $propertyName = $property->getName();

            if (\ArtARTs36\Str\Facade\Str::isNotEmpty($propertyPrefix)) {
                $propertyName = $propertyPrefix . '.' . $propertyName;
            }

            if (class_exists($property->getType()->getName()) && $this->allowObjectScan($property->getType()->getName())) {
                $opArray = array_merge($opArray, $this->doGenerate(
                    new \ReflectionClass($property->getType()->getName()),
                    $operatorMetadata,
                    $opArray,
                    $propertyName,
                ));

                continue;
            }

            $opArray['properties'][$propertyName] = [
                'type' => 'object',
                'properties' => [],
            ];

            foreach ($property->getAttributes(SupportsConditionEvaluator::class) as $attribute) {
                $operators = current($attribute->getArguments());

                foreach ($operators as $operatorClass) {
                    $operatorMeta = $operatorMetadata[$operatorClass];

                    if ($operatorMeta->evaluatesSameType) {
                        $val = [
                            'description' => $operatorMeta->description,
                            'type' => JsonType::to($property->getType()->getName()),
                        ];

                        foreach ($operatorMeta->names as $operatorName) {
                            $opArray['properties'][$propertyName]['properties'][$operatorName] = $val;
                        }

                        continue;
                    }

                    if ($operatorMeta->evaluatesGenericType) {
                        $genericAttr = $property->getAttributes(Generic::class);
                        $genericType = current(current($genericAttr)->getArguments());

                        $val = [
                            'description' => $operatorMeta->description,
                            'type' => JsonType::to($genericType),
                        ];

                        foreach ($operatorMeta->names as $operatorName) {
                            $opArray['properties'][$propertyName]['properties'][$operatorName] = $val;
                        }

                        continue;
                    }

                    $opParamTypes = $operatorMeta->allowValues;

                    if (count($opParamTypes) === 1) {
                        foreach ($operatorMeta->names as $operatorName) {
                            $v = [
                                'description' => $operatorMeta->description,
                                'type' => $opParamTypes[0]->jsonType,
                            ];

                            if ($opParamTypes[0]->isGeneric()) {
                                $v['items'] = [
                                    'type' => $opParamTypes[0]->generic,
                                ];
                            }

                            $opArray['properties'][$propertyName]['properties'][$operatorName] = $v;
                        }
                    } else {
                        $anyOf = [];

                        foreach ($opParamTypes as $pType) {
                            $anyOf[] = [
                                'type' => $pType,
                            ];
                        }

                        foreach ($operatorMeta->names as $operatorName) {
                            $opArray['properties'][$propertyName]['properties'][$operatorName]['anyOf'] = $anyOf;
                        }
                    }
                }
            }
        }

        return $opArray;
    }

    private function allowObjectScan(string $type): bool
    {
        return $type !== Set::class && $type !== Str::class;
    }
}
