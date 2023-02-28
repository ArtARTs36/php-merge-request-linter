<?php

use ArtARTs36\MergeRequestLinter\DocBuilder\ConditionsPageBuilder;
use ArtARTs36\MergeRequestLinter\DocBuilder\Saver;

require __DIR__ . '/../../vendor/autoload.php';

$path = __DIR__ . '/../conditions.md';
[$builder, $saver] = [new ConditionsPageBuilder(), new Saver()];

$updated = $saver->save($path, $builder->build());

fputs(STDOUT, $updated ? '-> Documentation page updated' : '-> Documentation page is actually');
fputs(STDOUT, "\n");
