<?php

namespace ArtARTs36\MergeRequestLinter\Support;

use ArtARTs36\MergeRequestLinter\Contracts\YamlParser;
use Symfony\Component\Yaml\Parser;

class SymfonyYamlParser implements YamlParser
{
    public function __construct(
        private readonly Parser $parser = new Parser(),
    ) {
        //
    }

    public function parse(string $yaml): array
    {
        return $this->parser->parse($yaml);
    }
}
