<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\InvalidConfigValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\TransformConfigValueException;

class CompositeTransformer implements ConfigValueTransformer
{
    /**
     * @param iterable<ConfigValueTransformer> $transformers
     */
    public function __construct(
        private readonly iterable $transformers,
    ) {
        //
    }

    public function supports(string $value): bool
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return true;
            }
        }

        return false;
    }

    public function transform(string $value): string
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        throw new InvalidConfigValueException(sprintf('value "%s" not transformed', $value));
    }

    public function tryTransform(string $value): string
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($value)) {
                return $transformer->transform($value);
            }
        }

        return $value;
    }
}
