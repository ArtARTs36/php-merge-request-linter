<?php

require __DIR__ . '/../../vendor/autoload.php';

$jsonSchema = new \ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Generator();

$path = __DIR__ . '/../../mr-linter-config-schema.json';
$prevHash = md5_file($path);

file_put_contents($path, $json = $jsonSchema->generate()->toJson());

$updated = $prevHash !== md5($json);

fputs(STDOUT, $updated ? '-> Documentation page updated' : '-> Documentation page is actually');
fputs(STDOUT, "\n");
