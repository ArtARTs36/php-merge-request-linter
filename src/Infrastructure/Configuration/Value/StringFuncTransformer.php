<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigValueTransformer;
use ArtARTs36\Str\Facade\Str;

abstract class StringFuncTransformer implements ConfigValueTransformer
{
    protected const FUNC_NAME = '';

    abstract protected function doTransform(string $preparedValue): string;

    public function supports(string $value): bool
    {
        return Str::hasPrefixAndSuffix($value, static::FUNC_NAME . '(', ')');
    }

    public function transform(string $value): string
    {
        return $this->doTransform(Str::between($value, static::FUNC_NAME . '(', ')'));
    }
}
