<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

class Application extends \Symfony\Component\Console\Application
{
    public const VERSION = '4.0.1';

    public function __construct()
    {
        parent::__construct('Merge Request Linter', self::VERSION);
    }
}
