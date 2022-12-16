<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Attribute\SupportsConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
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

        foreach ($reflector->getProperties() as $property) {
            $opArray['properties'][$property->getName()] = [
                'type' => 'object',
                'properties' => [],
            ];

            foreach ($property->getAttributes(SupportsConditionOperator::class) as $attribute) {
                $operators = current($attribute->getArguments());

                foreach ($operators as $operatorClass) {
                    $operatorMeta = $operatorMetadata[$operatorClass];

                    if ($operatorMeta->evaluatesSameType) {
                        $opArray['properties'][$property->getName()]['properties'][$operatorMeta->name] = [
                            'type' => $this->prepareTypeToPrimitive($property->getType()->getName()),
                        ];

                        continue;
                    }

                    $opParamTypes = $operatorMeta->allowValueTypes;

                    if (count($opParamTypes) === 1) {
                        $opArray['properties'][$property->getName()]['properties'][$operatorMeta->name] = [
                            'type' => $opParamTypes[0],
                        ];
                    } else {
                        $anyOf = [];

                        foreach ($opParamTypes as $pType) {
                            $anyOf[] = [
                                'type' => $pType,
                            ];
                        }

                        $opArray['properties'][$property->getName()]['properties'][$operatorMeta->name]['anyOf'] = $anyOf;
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
