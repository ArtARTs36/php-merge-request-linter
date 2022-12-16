<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Contracts\RuleConstructorFinder;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Constructor\ConstructorFinder;

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
                    $ruleSchema['properties'][$paramName] = [
                        'type' => JsonType::to($paramType),
                    ];

                    $ruleSchema['required'][] = $paramName;
                }
            }

            $schema[$rule::NAME] = $ruleSchema;
        }

        return $schema;
    }
}
