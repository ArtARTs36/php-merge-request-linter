<?php

require __DIR__ . '/../../vendor/autoload.php';

$jsonSchema = new \ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Generator();

$json = json_encode($jsonSchema->generate(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

file_put_contents(__DIR__ . '/../../mr-linter-config-schema.json', $json);
