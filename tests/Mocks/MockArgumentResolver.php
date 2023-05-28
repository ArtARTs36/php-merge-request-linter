<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ArgumentResolver;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;

final class MockArgumentResolver implements ArgumentResolver
{
    public function __construct(
        private readonly bool $canResolve = true,
        private readonly mixed $resolvedValue = null,
    ) {
        //
    }

    public function canResolve(Type $type, mixed $value): bool
    {
        return $this->canResolve;
    }

    public function resolve(Type $type, mixed $value): mixed
    {
        return $this->resolvedValue;
    }
}
