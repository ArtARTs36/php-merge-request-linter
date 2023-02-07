<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;
use ArtARTs36\Str\Facade\Str;

class RuleSchemaGenerator
{
    public function __construct(
        private RuleConstructorFinder $constructorFinder = new ConstructorFinder(),
    ) {
        //
    }

    public function generate(JsonSchema $jsonSchema): array
    {
        $rules = DefaultRules::map();
        $schema = [];

        foreach ($rules as $ruleName => $rule) {
            $ruleSchema = [
                'description' => Reflector::findPHPDocSummary(new \ReflectionClass($rule)),
            ];

            $constructor = $this->constructorFinder->find($rule);
            $params = $constructor->params();

            $definition = [
                'type' => 'object',
                'properties' => [
                    'when' => [
                        '$ref' => '#/definitions/rule_conditions',
                    ],
                ],
            ];

            if (count($params) > 0) {
                foreach ($constructor->params() as $paramName => $paramType) {
                    $typeSchema = [
                        'type' => JsonType::to($paramType->class ?? $paramType->name->value),
                    ];

                    if ($typeSchema['type'] === null) {
                        continue 2;
                    }

                    if ($paramType->isGeneric()) {
                        if ($paramType->isGenericOfObject()) {
                            $genericProps = [];

                            foreach (Reflector::mapPropertyTypes($paramType->generic) as $propertyName => $propertyType) {
                                $genericProps[$propertyName] = [
                                    'type' => JsonType::to($propertyType->class ?? $propertyType->name->value),
                                ];
                            }

                            $typeSchema['items'] = [
                                'type' => 'object',
                                'properties' => $genericProps,
                            ];
                        } else {
                            $typeSchema['items'] = [
                                [
                                    'type' => $paramType->generic,
                                ],
                            ];
                        }
                    }

                    $definition['properties'][$paramName] = $typeSchema;
                    $definition['required'][] = $paramName;
                }
            }

            $definitionName = Str::replace('rules_properties_' . $ruleName, [
                '/' => '_',
            ]);

            $propertyDefinitionRef = $jsonSchema->addDefinition($definitionName, $definition);

            $ruleSchema['oneOf'] = [
                [
                    '$ref' => $propertyDefinitionRef,
                ],
                [
                    'type' => 'array',
                    'items' => [
                        '$ref' => $propertyDefinitionRef,
                    ],
                    'minItems' => 1,
                ],
            ];

            $schema[$ruleName] = $ruleSchema;
        }

        return $schema;
    }
}
