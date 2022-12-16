<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
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

            foreach ($property->getAttributes(SupportsConditionOperator::class) as $attribute) {
                $operators = current($attribute->getArguments());

                foreach ($operators as $operatorClass) {
                    $operatorMeta = $operatorMetadata[$operatorClass];

                    if ($operatorMeta->evaluatesSameType) {
                        $opArray['properties'][$propertyName]['properties'][$operatorMeta->name] = [
                            'type' => $this->prepareTypeToPrimitive($property->getType()->getName()),
                        ];

                        continue;
                    }

                    $opParamTypes = $operatorMeta->allowValueTypes;

                    if (count($opParamTypes) === 1) {
                        $opArray['properties'][$propertyName]['properties'][$operatorMeta->name] = [
                            'type' => $opParamTypes[0],
                        ];
                    } else {
                        $anyOf = [];

                        foreach ($opParamTypes as $pType) {
                            $anyOf[] = [
                                'type' => $pType,
                            ];
                        }

                        $opArray['properties'][$propertyName]['properties'][$operatorMeta->name]['anyOf'] = $anyOf;
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

    private function prepareTypeToPrimitive(string $type): string
    {
        if ($type === Str::class) {
            return 'string';
        }

        return $type;
    }
}
