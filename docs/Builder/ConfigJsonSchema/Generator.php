<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;

class Generator
{
    public function __construct(
        private RuleSchemaGenerator $ruleSchemaGenerator = new RuleSchemaGenerator(),
        private OperatorSchemaArrayGenerator $operatorSchemaArrayGenerator = new OperatorSchemaArrayGenerator(),
    ) {
        //
    }

    public function generate(): JsonSchema
    {
        $schema = new JsonSchema();

        $schema->addDefinition('rule_conditions', $this->operatorSchemaArrayGenerator->generate());

        $schema->addProperty('rules', [
            'type' => 'object',
            'properties' => $this->ruleSchemaGenerator->generate($schema),
            'additionalProperties' => false,
        ]);

        $schema->addProperty('credentials', [
            'type' => 'object',
            'properties' => [
                'gitlab_ci' => [
                    'description' => 'Token',
                    'type' => 'string',
                ],
                'github_actions' => [
                    'description' => 'Token',
                    'type' => 'string',
                ],
            ],
            'additionalProperties' => false,
        ]);

        return $schema;
    }
}
