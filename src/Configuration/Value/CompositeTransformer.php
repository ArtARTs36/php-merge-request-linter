<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigValueTransformer;

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

        return $value;
    }
}
