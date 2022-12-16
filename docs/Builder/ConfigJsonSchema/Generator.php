<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

class Generator
{
    public function __construct(
        private RuleSchemaGenerator $ruleSchemaGenerator = new RuleSchemaGenerator(),
        private OperatorSchemaArrayGenerator $operatorSchemaArrayGenerator = new OperatorSchemaArrayGenerator(),
    ) {
        //
    }

    public function generate(): array
    {
        return [
            '$schema' => 'http://json-schema.org/draft-04/schema#',
            'type' => 'object',
            'properties' => $this->ruleSchemaGenerator->generate(),
            'definitions' => [
                'rule_conditions' => $this->operatorSchemaArrayGenerator->generate(),
            ]
        ];
    }
}
