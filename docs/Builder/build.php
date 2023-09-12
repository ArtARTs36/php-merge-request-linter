<?php

use ArtARTs36\MergeRequestLinter\DocBuilder\ConditionsPageBuilder;
use ArtARTs36\MergeRequestLinter\DocBuilder\RulesPageBuilder;

require __DIR__ . '/../../vendor/autoload.php';

$builders = [
    [
        'name' => 'Rules page',
        'path' => __DIR__ . '/../rules.md',
        'builder' => function () {
            $builder = new RulesPageBuilder();

            return $builder->build();
        },
    ],
    [
        'name' => 'Config JSON Schema',
        'path' => __DIR__ . '/../../mr-linter-config-schema.json',
        'builder' => function () {
            $jsonSchema = new \ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Generator();

            return $jsonSchema->generate()->toJson();
        },
    ],
    [
        'name' => 'Conditions page',
        'path' => __DIR__ . '/../conditions.md',
        'builder' => function () {
            $builder = new ConditionsPageBuilder();

            return $builder->build();
        },
    ],
];

$saver = new \ArtARTs36\MergeRequestLinter\DocBuilder\Saver();

foreach ($builders as $builder) {
    $result = $builder['builder']();

    $updated = $saver->save($builder['path'], $result);

    if ($updated) {
        echo sprintf('-> %s: Documentation page updated', $builder['name']) . "\n";
    } else {
        echo sprintf('-> %s: Documentation page is actually', $builder['name']) . "\n";
    }
}
