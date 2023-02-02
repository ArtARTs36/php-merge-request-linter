<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema;

use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\JsonType;

class JsonSchema
{
    private array $schema = [
        '$schema' => 'http://json-schema.org/draft-04/schema#',
        'type' => JsonType::OBJECT,
        'properties' => [],
        'definitions' => [],
        'required' => [],
    ];

    public function addDefinition(string $name, array $definition): string
    {
        $this->schema['definitions'][$name] = $definition;

        return '#/definitions/' . $name;
    }

    public function addProperty(string $name, array $prop, bool $required = true): void
    {
        $this->schema['properties'][$name] = $prop;

        if ($required) {
            $this->schema['required'][] = $name;
        }
    }

    public function toJson(): string
    {
        return json_encode($this->schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
