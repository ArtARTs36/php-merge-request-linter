<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
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
        ]);

        $schema->addProperty('reports', [
            'type' => 'object',
            'properties' => [
                'reporter' => [
                    'type' => 'object',
                    'properties' => [
                        'uri' => [
                            'type' => 'string',
                        ],
                        'suppress_exceptions' => [
                            'type' => 'boolean',
                        ],
                        'http_client' => [
                            'type' => 'object',
                            'properties' => [
                                'type' => [
                                    'type' => 'string',
                                    'enum' => HttpClientConfig::TYPES,
                                ],
                                'params' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'headers' => [
                                            'type' => 'object',
                                        ],
                                        'proxy' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'required' => [
                        'uri',
                    ],
                ],
            ],
        ], false);

        return $schema;
    }
}
