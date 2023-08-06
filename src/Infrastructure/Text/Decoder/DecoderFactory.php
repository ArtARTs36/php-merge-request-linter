<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecoderNotFoundException;

class DecoderFactory
{
    private const MAP = [
        'json' => NativeJsonProcessor::class,
        'yaml' => SymfonyYamlDecoder::class,
    ];

    public function create(string $format): TextDecoder
    {
        $class = self::MAP[$format] ?? null;

        if ($class === null) {
            throw new TextDecoderNotFoundException(sprintf('Decoder for format "%s" not found', $format));
        }

        return new $class();
    }
}
