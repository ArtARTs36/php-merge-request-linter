<?php

require __DIR__ . '/../../vendor/autoload.php';

$jsonSchema = new \ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Generator();

$prevHash = md5_file(__DIR__ . '/../../mr-linter-config-schema.json');

$newSchemaJson = $jsonSchema->generate()->toJson();

if (md5($newSchemaJson) === $prevHash) {
    fputs(STDOUT, 'JsonSchema: not changes');
} else {
    fputs(STDOUT, 'JsonSchema: updated');

    file_put_contents(__DIR__ . '/../../mr-linter-config-schema.json', $newSchemaJson);
}

fputs(STDOUT, "\n");
