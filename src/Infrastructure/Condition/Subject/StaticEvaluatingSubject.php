<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\TypeCaster;

class StaticEvaluatingSubject implements EvaluatingSubject
{
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
        private readonly TypeCaster $caster = new TypeCaster(),
    ) {
    }

    public function scalar(): int|string|float|bool
    {
        return $this->caster->scalar($this->value);
    }

    public function interface(string $interface): mixed
    {
        return $this->caster->interface($interface, $this->value);
    }

    public function name(): string
    {
        return $this->name;
    }
}
