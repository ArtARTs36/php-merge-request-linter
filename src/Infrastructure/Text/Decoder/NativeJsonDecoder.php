<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecodingException;

class NativeJsonDecoder implements TextDecoder
{
    public function decode(string $content): array
    {
        $data = \json_decode($content, true);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new TextDecodingException('json_decode error: ' . \json_last_error_msg());
        }

        if (! is_array($data)) {
            throw new TextDecodingException('JSON content invalid');
        }

        return $data;
    }
}
