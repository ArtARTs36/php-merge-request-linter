<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

interface ArgResolver
{
    public function resolve(mixed $value): mixed;
}
