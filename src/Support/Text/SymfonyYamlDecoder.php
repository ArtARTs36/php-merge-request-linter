<?php

namespace ArtARTs36\MergeRequestLinter\Support\Text;

use ArtARTs36\MergeRequestLinter\Contracts\Text\YamlDecoder;
use ArtARTs36\MergeRequestLinter\Exception\TextDecodingException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class SymfonyYamlDecoder implements YamlDecoder
{
    public function __construct(
        private readonly Parser $parser = new Parser(),
    ) {
        //
    }

    public function decode(string $content): array
    {
        try {
            return $this->parser->parse($content);
        } catch (ParseException $e) {
            throw new TextDecodingException($e->getMessage(), previous: $e);
        }
    }
}
