<?php

use ArtARTs36\MergeRequestLinter\DocBuilder\RulesPageBuilder;
use ArtARTs36\MergeRequestLinter\DocBuilder\Saver;

require __DIR__ . '/../../vendor/autoload.php';

$path = __DIR__ . '/../rules.md';
[$builder, $saver] = [new RulesPageBuilder(), new Saver()];

$updated = $saver->save($path, $builder->build());

fputs(STDOUT, $updated ? 'Documentation page updated' : 'Documentation page is actually');
fputs(STDOUT, "\n");
