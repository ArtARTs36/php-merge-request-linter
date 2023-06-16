<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Decoder;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextProcessor;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Exceptions\TextDecodingException;

final class NativeJsonProcessor implements TextProcessor
{
    public function encode(array $data): string
    {
        $encoded = \json_encode($data);

        return $encoded === false ? '' : $encoded;
    }

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
