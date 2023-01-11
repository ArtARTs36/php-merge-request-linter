<?php

namespace ArtARTs36\MergeRequestLinter\Console\Application;

class Application extends \Symfony\Component\Console\Application
{
    public const VERSION = '0.6.0';

    public function __construct()
    {
        parent::__construct('Merge Request Linter', self::VERSION);
    }
}
