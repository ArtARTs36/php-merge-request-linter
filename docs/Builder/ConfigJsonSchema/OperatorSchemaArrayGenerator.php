<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\CompositeEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountMinEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Counts\CountNotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\EqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Generic\IsEmptyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\GteEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\HasEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LinesMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\LteEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotEqualsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\NotHasEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsCamelCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsKebabCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsLowerCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsSnakeCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsStudlyCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Cases\IsUpperCaseEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\ContainsLineEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\EndsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMaxEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\LengthMinOperator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown\ContainsHeadingEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\MatchEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotEndsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsAnyEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\NotStartsEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\StartsEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Property;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Reflector;
use ArtARTs36\Str\Markdown;
use ArtARTs36\Str\Str;

class OperatorSchemaArrayGenerator
{
    private array $typeEvaluatorsMap = [
        'string' => [
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
            IsEmptyEvaluator::class,
            IsCamelCaseEvaluator::class,
            IsStudlyCaseEvaluator::class,
            IsUpperCaseEvaluator::class,
            IsLowerCaseEvaluator::class,
            IsSnakeCaseEvaluator::class,
            IsKebabCaseEvaluator::class,
            LinesMaxEvaluator::class,
            ContainsLineEvaluator::class,
            NotStartsAnyEvaluator::class,
        ],
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
            IsEmptyEvaluator::class,
            IsCamelCaseEvaluator::class,
            IsStudlyCaseEvaluator::class,
            IsUpperCaseEvaluator::class,
            IsLowerCaseEvaluator::class,
            IsSnakeCaseEvaluator::class,
            IsKebabCaseEvaluator::class,
            LinesMaxEvaluator::class,
            ContainsLineEvaluator::class,
            NotStartsAnyEvaluator::class,
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
            NotHasAnyEvaluator::class,
            IsEmptyEvaluator::class,
            AllEvaluator::class,
            AnyEvaluator::class,
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
            NotHasAnyEvaluator::class,
            IsEmptyEvaluator::class,
            AllEvaluator::class,
            AnyEvaluator::class,
        ],
        Arrayee::class => [
            CountMinEvaluator::class,
            CountMaxEvaluator::class,
            CountEqualsEvaluator::class,
            CountNotEqualsEvaluator::class,
            CountEqualsAnyEvaluator::class,
            HasEvaluator::class,
            NotHasEvaluator::class,
            NotHasAnyEvaluator::class,
            HasAnyEvaluator::class,
            IsEmptyEvaluator::class,
            AllEvaluator::class,
            AnyEvaluator::class,
        ],
        'bool' => [
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
        ],
        'float' => [
            EqualsEvaluator::class,
            NotEqualsEvaluator::class,
            LteEvaluator::class,
            GteEvaluator::class,
        ],
        Markdown::class => [
            ContainsHeadingEvaluator::class,
        ],
    ];

    public function __construct(
        private OperatorMetadataLoader $operatorMetadataLoader = new OperatorMetadataLoader(),
    ) {
        //
    }

    public function generate(string $forClass): array
    {
        $opArray = [
            'properties' => [],
            'additionalProperties' => false,
        ];

        $operatorMetadata = $this->operatorMetadataLoader->load();

        return $this->doGenerate(Reflector::mapProperties($forClass), $operatorMetadata, $opArray, '');
    }

    /**
     * @param array<string, Property> $properties
     * @param array<class-string<ConditionOperator>, OperatorMetadata> $operatorMetadata
     */
    private function doGenerate(array $properties, array $operatorMetadata, array $opArray, string $propertyPrefix): array
    {
        foreach ($properties as $property) {
            $propertyName = $property->name;

            if (\ArtARTs36\Str\Facade\Str::isNotEmpty($propertyPrefix)) {
                $propertyName = $propertyPrefix . '.' . $propertyName;
            }

            if ($property->type->isClass() && $this->allowObjectScan($property->type->class)) {
                $opArray = array_merge($opArray, $this->doGenerate(
                    Reflector::mapProperties($property->type->class),
                    $operatorMetadata,
                    $opArray,
                    $propertyName,
                ));

                continue;
            }

            $opArray['properties'][$propertyName] = [
                'type' => 'object',
                'properties' => [],
                'additionalProperties' => false,
            ];

            $operators = $this->typeEvaluatorsMap[$property->type->name()] ?? null;

            if ($operators === null) {
                continue;
            }

            foreach ($operators as $operatorClass) {
                $operatorMeta = $operatorMetadata[$operatorClass];

                if (is_subclass_of($operatorClass, CompositeEvaluator::class)) {
                    if (! isset($this->typeEvaluatorsMap[$property->type->generic])) {
                        continue;
                    }

                    $val = [
                        'description' => $operatorMeta->description,
                        'type' => JsonType::OBJECT,
                        'properties' => [],
                        'additionalProperties' => false,
                    ];

                    foreach ($this->typeEvaluatorsMap[$property->type->generic] as $subEvaluatorClass) {
                        $subEvaluatorMeta = $operatorMetadata[$subEvaluatorClass];

                        if ($subEvaluatorMeta->parameters[0]->isGeneric()) {
                            $jsonType = JsonType::to($subEvaluatorMeta->parameters[0]->generic);
                        } else {
                            $jsonType = $subEvaluatorMeta->parameters[0]->jsonType;
                        }

                        $subEvaluatorData = [
                            'description' => $subEvaluatorMeta->description,
                            'type' => $jsonType,
                        ];

                        foreach ($subEvaluatorMeta->names as $name) {
                            $val['properties'][$name] = $subEvaluatorData;
                        }
                    }

                    foreach ($operatorMeta->names as $operatorName) {
                        $opArray['properties'][$propertyName]['properties'][$operatorName] = $val;
                    }

                    continue;
                }

                if ($operatorMeta->evaluatesSameType) {
                    $jsonType = JsonType::to($property->type->name());

                    if ($jsonType === null) {
                        continue;
                    }

                    $val = [
                        'description' => $operatorMeta->description,
                        'type' => $jsonType,
                    ];

                    foreach ($operatorMeta->names as $operatorName) {
                        $opArray['properties'][$propertyName]['properties'][$operatorName] = $val;
                    }

                    continue;
                }

                if ($operatorMeta->evaluatesGenericType) {
                    $jsonType = JsonType::to($property->type->generic);

                    if ($jsonType === null) {
                        continue;
                    }

                    $val = [
                        'description' => $operatorMeta->description,
                        'type' => $jsonType,
                    ];

                    foreach ($operatorMeta->names as $operatorName) {
                        $opArray['properties'][$propertyName]['properties'][$operatorName] = $val;
                    }

                    continue;
                }

                $opArray['properties'][$propertyName]['properties'] = array_merge(
                    $opArray['properties'][$propertyName]['properties'],
                    $this->mapEvaluatorData($operatorMeta),
                );
            }
        }

        return $opArray;
    }

    private function mapEvaluatorData(OperatorMetadata $operatorMeta): array
    {
        $opParamTypes = $operatorMeta->parameters;

        if (count($opParamTypes) === 1) {
            $values = [];

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

               $values[$operatorName] = $v;
            }

            return $values;
        }

        $anyOf = [];

        foreach ($opParamTypes as $pType) {
            $anyOf[] = [
                'type' => $pType,
            ];
        }

        $v = [];

        foreach ($operatorMeta->names as $operatorName) {
            $v[$operatorName]['anyOf'] = $anyOf;
        }

        return $v;
    }

    private function allowObjectScan(string $type): bool
    {
        return $type !== ArrayMap::class && $type !== Set::class && $type !== Str::class && $type !== Markdown::class && $type !== Arrayee::class;
    }
}
