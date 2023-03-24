<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Normalizer;

use ArtARTs36\Normalizer\Normalizer;
use ArtARTs36\Normalizer\Property\ClosurePropertyAccessor;
use ArtARTs36\Normalizer\Type\DateTimeImmutableResolver;
use ArtARTs36\Normalizer\Type\ScalarTypeResolver;
use ArtARTs36\Normalizer\Type\SplFixedArrayTypeResolver;

class NormalizerFactory
{
    public function create(): Normalizer
    {
        return Normalizer::create(new ClosurePropertyAccessor(), [
            new ScalarTypeResolver(),
            new DateTimeImmutableResolver(),
            new SplFixedArrayTypeResolver(),
            new StrTypeResolver(),
        ]);
    }
}
