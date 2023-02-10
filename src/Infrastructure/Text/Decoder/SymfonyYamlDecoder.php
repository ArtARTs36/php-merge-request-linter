<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecodingException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class SymfonyYamlDecoder implements TextDecoder
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
