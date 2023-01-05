<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\Config;

/**
 * Value transformer for config.
 */
interface ConfigValueTransformer
{
    /**
     * Determine supports transform.
     */
    public function supports(string $value): bool;

    /**
     * Transform value.
     */
    public function transform(string $value): string;
}
