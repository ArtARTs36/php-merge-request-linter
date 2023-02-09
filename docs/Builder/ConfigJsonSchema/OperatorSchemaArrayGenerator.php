<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Condition\Evaluator\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountEqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountMinEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\CountNotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\HasEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEndsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotHasEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\NotStartsEvaluator;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\StartsEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;
use ArtARTs36\Str\Str;

class OperatorSchemaArrayGenerator
{
    private array $typeEvaluatorsMap = [
        Str::class => [
            EqualsEvaluator::class,
            LengthMinOperator::class,
            LengthMaxEvaluator::class,
            StartsEvaluator::class,
            NotStartsEvaluator::class,
            EndsEvaluator::class,
            NotEndsEvaluator::class,
            ContainsEvaluator::class,
            NotEqualsEvaluator::class,
            EqualsAnyEvaluator::class,
            MatchEvaluator::class,
        ],
        Set::class => [
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            CountEqualsEvaluator::class,
            CountNotEqualsEvaluator::class,
            CountEqualsAnyEvaluator::class,
            HasEvaluator::class,
            NotHasEvaluator::class,
            HasAnyEvaluator::class,
        ],
        Map::class => [
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            CountEqualsEvaluator::class,
            CountNotEqualsEvaluator::class,
            CountEqualsAnyEvaluator::class,
            HasEvaluator::class,
            NotHasEvaluator::class,
            HasAnyEvaluator::class,
        ],
        'bool' => [
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ],
    ];

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

            $operators = $this->typeEvaluatorsMap[$property->getType()->getName()] ?? null;

            if ($operators === null) {
                continue;
            }

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

                $opParamTypes = $operatorMeta->parameters;

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

        return $opArray;
    }

    private function allowObjectScan(string $type): bool
    {
        return $type !== Set::class && $type !== Str::class;
    }
}
