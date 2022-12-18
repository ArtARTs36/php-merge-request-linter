<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Reflector;

class RuleSchemaGenerator
{
    public function __construct(
        private RuleConstructorFinder $constructorFinder = new ConstructorFinder(),
    ) {
        //
    }

    public function generate()
    {
        $rules = DefaultRules::map();
        $schema = [];

        foreach ($rules as $rule) {
            $ruleSchema = [
                'type' => 'object',
                'description' => Reflector::findPHPDocSummary(new \ReflectionClass($rule)),
                'properties' => [
                    'when' => [
                        '$ref' => '#/definitions/rule_conditions',
                    ],
                ]
            ];

            $constructor = $this->constructorFinder->find($rule);
            $params = $constructor->params();

            if (count($params) > 0) {
                $ruleSchema['required'] = [];
                foreach ($constructor->params() as $paramName => $paramType) {
                    $typeSchema = [
                        'type' => JsonType::to($paramType->name),
                    ];

                    if ($paramType->isGeneric()) {
                        $typeSchema['items'] = [
                            [
                                'type' => $paramType->generic,
                            ],
                        ];
                    }

                    $ruleSchema['properties'][$paramName] = $typeSchema;

                    $ruleSchema['required'][] = $paramName;
                }
            }

            $schema[$rule::NAME] = $ruleSchema;
        }

        return $schema;
    }
}
