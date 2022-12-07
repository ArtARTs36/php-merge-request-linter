<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

interface ConfigValueTransformer
{
    public function supports(string $value): bool;

    public function transform(string $value): string;
}
