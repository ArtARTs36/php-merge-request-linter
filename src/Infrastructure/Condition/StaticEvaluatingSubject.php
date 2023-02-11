<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

class StaticEvaluatingSubject implements EvaluatingSubject
{
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
        private readonly TypeCaster $caster = new TypeCaster(),
    ) {
        //
    }

    public function numeric(): int|float
    {
        return $this->caster->numeric($this->value);
    }

    public function scalar(): int|string|float|bool
    {
        return $this->caster->scalar($this->value);
    }

    public function string(): Str
    {
        return $this->caster->string($this->value);
    }

    public function collection(): Collection
    {
        return $this->caster->collection($this->value);
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
