<?php

namespace ArtARTs36\MergeRequestLinter\Support\Text;

use ArtARTs36\MergeRequestLinter\Contracts\Text\JsonDecoder;
use GuzzleHttp\Exception\InvalidArgumentException;

class NativeJsonDecoder implements JsonDecoder
{
    public function decode(string $json): array
    {
        $data = \json_decode($json);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new InvalidArgumentException('json_decode error: ' . \json_last_error_msg());
        }

        return $data;
    }
}
