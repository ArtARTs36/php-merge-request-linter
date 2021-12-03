<?php

use ArtARTs36\MergeRequestLinter\DocBuilder\RulesPageBuilder;

require __DIR__ . '/../../vendor/autoload.php';

$builder = new RulesPageBuilder();

file_put_contents(__DIR__ . '/../rules.md', $builder->build());
