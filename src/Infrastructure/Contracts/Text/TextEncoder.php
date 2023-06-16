<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text;

interface TextEncoder
{
    public function encode(array $data): string;
}
