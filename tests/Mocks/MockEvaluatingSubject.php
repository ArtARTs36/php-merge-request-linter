<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Str;

class MockEvaluatingSubject implements EvaluatingSubject
{
    public function __construct(
        private mixed $value,
    ) {
        //
    }

    public function numeric(): int|float
    {
        return $this->value;
    }

    public function scalar(): int|string|float|bool
    {
        return $this->value;
    }

    public function string(): Str
    {
        return new Str($this->value);
    }

    public function collection(): Collection
    {
        return new Arrayee($this->value);
    }

    public function interface(string $interface): mixed
    {
        return $this->value;
    }

    public function name(): string
    {
        return 'mock';
    }
}
