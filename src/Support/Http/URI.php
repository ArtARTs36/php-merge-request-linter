<?php

namespace ArtARTs36\MergeRequestLinter\Support\Http;

class URI
{
    public static function host(string $uri): string
    {
        $host = parse_url($uri, PHP_URL_HOST);

        return is_string($host) ? $host : '';
    }
}
