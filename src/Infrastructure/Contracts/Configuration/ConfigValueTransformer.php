<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration;

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
     * @throws TransformConfigValueException
     */
    public function transform(string $value): string;

    /**
     * Transform value or return same value.
     */
    public function tryTransform(string $value): string;
}
