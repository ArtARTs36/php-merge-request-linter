<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\CustomRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\Finder;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Instantiator\InstantiatorFinder;
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
                foreach ($constructor->params() as $param) {
                    $paramSchema = $this->createRuleParamSchema(
                        $rule,
                        $param,
                    );

                    if ($paramSchema === null) {
                        continue;
                    }

                    $definition['properties'][$param->name] = $paramSchema;

                    if ($param->type->class !== null && Reflector::canConstructWithoutParameters($param->type->class)) {
                        // skipped
                    } else if ($param->isRequired()) {
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

    private function createRuleParamSchema(string $ruleClass, \ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Parameter $param): ?array
    {
        if (isset(self::OVERWRITE_PARAMS[$ruleClass][$param->name])) {
            return self::OVERWRITE_PARAMS[$ruleClass][$param->name];
        }

        $paramSchema = [
            'type' => JsonType::to($param->type->class ?? $param->type->name->value),
        ];

        if ($paramSchema['type'] === null) {
            return null;
        }

        if ($param->type->class !== null && enum_exists($param->type->class)) {
            /** @var \BackedEnum $enum */
            $enum = $param->type->class;

            $paramSchema['enum'] = array_map(function (\UnitEnum $unit) {
                return $unit->value;
            }, $enum::cases());
        }

        if ($param->description !== '') {
            $paramSchema['description'] = $param->description;
        }

        if ($param->type->isGeneric()) {
            $generic = $param->type->getObjectGeneric();

            if ($generic !== null) {
                $genericProps = [];

                foreach (Reflector::mapProperties($generic) as $property) {
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

                $paramSchema['items'] = [
                    $item,
                ];
            }
        } else if ($param->type->class !== null) {
            $subClassConstructor = $this->constructorFinder->find($param->type->class);

            foreach ($subClassConstructor->params() as $subClassParam) {
                $paramSchema['properties'][$subClassParam->name] = $this->createRuleParamSchema($ruleClass, $subClassParam);
            }
        }

        return $paramSchema;
    }
}
