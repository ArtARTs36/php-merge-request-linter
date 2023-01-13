<?php

require __DIR__ . '/../../vendor/autoload.php';

$jsonSchema = new \ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Generator();

file_put_contents(__DIR__ . '/../../mr-linter-config-schema.json', $jsonSchema->generate()->toJson());
