<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Reflector;
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
        private RulesMetadataLoader $rulesMetadataLoader = new RulesMetadataLoader(),
    ) {
        //
    }

    public function generate(JsonSchema $jsonSchema): array
    {
        $schema = [];
        $ruleMetadata = $this->rulesMetadataLoader->load();

        foreach ($ruleMetadata->rules as $ruleName => $rule) {
            $ruleSchema = [
                'description' => $rule->description,
            ];

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

            if (count($rule->params) > 0) {
                foreach ($rule->params as $param) {
                    $paramSchema = $this->createRuleParamSchema(
                        $rule->class,
                        $param,
                    );

                    if ($paramSchema === null) {
                        continue;
                    }

                    $definition['properties'][$param->name] = $paramSchema;

                    if ($param->type->class !== null && Reflector::canConstructWithoutParameters($param->type->class)) {
                        // skipped
                    } else if ($param->required) {
                        $definition['required'][] = $param->name;
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

    private function createRuleParamSchema(string $ruleClass, RuleParamMetadata $param): ?array
    {
        if (isset(self::OVERWRITE_PARAMS[$ruleClass][$param->name])) {
            return self::OVERWRITE_PARAMS[$ruleClass][$param->name];
        }

        if ($param->jsonType === null) {
            return null;
        }

        $paramSchema = [
            'type' => $param->jsonType,
        ];

        if (count($param->enum) > 0) {
            $paramSchema['enum'] = $param->enum;
        }

        if ($param->description !== '') {
            $paramSchema['description'] = $param->description;
        }

        if (count($param->examples) > 0 && ! $param->type->isGeneric()) {
            $paramSchema['examples'] = array_map(fn (Example $ex) => $ex->value, $param->examples);
        }

        if ($param->type->isGeneric()) {
            $objGeneric = $param->type->getObjectGeneric();

            if ($objGeneric !== null) {
                $genericProps = [];

                foreach (Reflector::mapProperties($objGeneric) as $property) {
                    $genericProps[$property->name] = [
                        'type' => JsonType::to($property->type->class ?? $property->type->name->value),
                    ];
                }

                $paramSchema['items'] = [
                    'type' => 'object',
                    'properties' => $genericProps,
                    'additionalProperties' => false,
                ];
            } else {
                $item = [
                    'type' => $param->type->generic,
                ];

                if ($param->description !== '') {
                    $item['description'] = $param->description;
                }

                if (count($param->examples) > 0) {
                    $item['examples'] = array_map(fn (Example $ex) => $ex->value, $param->examples);
                }

                $paramSchema['items'] = [
                    $item,
                ];
            }
        } else if (count($param->nestedObjectParams) > 0) {
            foreach ($param->nestedObjectParams as $nestedObjectParam) {
                $paramSchema['properties'][$nestedObjectParam->name] = $this->createRuleParamSchema($ruleClass, $nestedObjectParam);
            }
        }

        return $paramSchema;
    }
}
