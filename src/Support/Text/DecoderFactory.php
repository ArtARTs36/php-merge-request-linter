<?php

namespace ArtARTs36\MergeRequestLinter\Support\Text;

use ArtARTs36\MergeRequestLinter\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Exception\TextDecoderNotFoundException;

class DecoderFactory
{
    private const MAP = [
        'json' => NativeJsonDecoder::class,
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
