<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Factory\Argument;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Exception\ArgNotSupportedException;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\Reflector\ParameterType;

class ArrayeeResolver implements ArgumentResolver
{
    public const SUPPORT_TYPE = Arrayee::class;

    public function resolve(ParameterType $type, mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new ArgNotSupportedException(sprintf(
                'Arg with type %s not supported. Expected type: array',
                gettype($value),
            ));
        }

        return new Arrayee($value);
    }
}
