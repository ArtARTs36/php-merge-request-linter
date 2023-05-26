<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\Shared\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Instantiator\InstantiatorFinder;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Reflector;
use ArtARTs36\Str\Facade\Str;

class RuleSchemaGenerator
{
    private const OVERWRITE_PARAMS = [
        CustomRule::class => [
            'rules' => [
                '$ref' => '#/definitions/rule_conditions',
            ],
        ],
    ];

    public function __construct(
        private InstantiatorFinder $constructorFinder = new Finder(),
    ) {
        //
    }

    public function generate(JsonSchema $jsonSchema): array
    {
        $rules = DefaultRules::map();
        $schema = [];

        foreach ($rules as $ruleName => $rule) {
            $ruleReflector = new \ReflectionClass($rule);

            $ruleSchema = [
                'description' => Reflector::findPHPDocSummary($ruleReflector),
            ];

            $constructor = $this->constructorFinder->find($rule);
            $params = $constructor->params();

            $definition = [
                'type' => 'object',
                'properties' => [
                    'critical' => [
                        'type' => 'boolean',
                        'default' => true,
                    ],
                    'when' => [
                        'description' => 'Conditions that determine whether the rule should run.',
                        '$ref' => '#/definitions/rule_conditions',
                    ],
                ],
                'additionalProperties' => false,
            ];

            if (count($params) > 0) {
                foreach ($constructor->params() as $paramName => $param) {
                    $paramType = $param->type;

                    if (isset(self::OVERWRITE_PARAMS[$rule][$paramName])) {
                        $typeSchema = self::OVERWRITE_PARAMS[$rule][$paramName];
                    } else {
                        $typeSchema = [
                            'type' => JsonType::to($paramType->class ?? $paramType->name->value),
                        ];

                        if ($typeSchema['type'] === null) {
                            continue;
                        }

                        if ($param->description !== '') {
                            $typeSchema['description'] = $param->description;
                        }

                        if ($paramType->isGeneric()) {
                            $generic = $paramType->getObjectGeneric();

                            if ($generic !== null) {
                                $genericProps = [];

                                foreach (Reflector::mapProperties($generic) as $property) {
                                    $genericProps[$property->name] = [
                                        'type' => JsonType::to($property->type->class ?? $property->type->name->value),
                                    ];
                                }

                                $typeSchema['items'] = [
                                    'type' => 'object',
                                    'properties' => $genericProps,
                                    'additionalProperties' => false,
                                ];
                            } else {
                                $item = [
                                    'type' => $paramType->generic,
                                ];

                                if ($param->description !== '') {
                                    $item['description'] = $param->description;
                                }

                                $typeSchema['items'] = [
                                    $item,
                                ];
                            }
                        }
                    }

                    $definition['properties'][$paramName] = $typeSchema;

                    if (! $paramType->nullable) {
                        $definition['required'][] = $paramName;
                    }
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
