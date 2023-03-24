<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Text\Normalizer;

use ArtARTs36\Normalizer\Contracts\TypeResolver;
use ArtARTs36\Normalizer\Value\UnresolvedValue;
use ArtARTs36\Str\Str;

class StrTypeResolver implements TypeResolver
{
    public function supportedTypesForDenormalization(): array
    {
        return [
            Str::class,
        ];
    }

    public function resolveTypeForDenormalization(\ReflectionProperty $property, mixed $value): mixed
    {
        if (! is_string($value)) {
            return new UnresolvedValue([
                'value' => $value,
            ]);
        }

        return Str::make($value);
    }
}
