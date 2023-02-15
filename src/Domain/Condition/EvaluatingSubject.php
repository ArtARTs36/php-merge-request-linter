<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

/**
 * Interface for evaluating Subject.
 */
interface EvaluatingSubject
{
    /**
     * Extract numeric property.
     * @throws EvaluatingSubjectException
     */
    public function numeric(): int|float;

    /**
     * Extract scalar property.
     * @throws EvaluatingSubjectException
     */
    public function scalar(): int|string|float|bool;

    /**
     * Extract string property.
     * @throws EvaluatingSubjectException
     */
    public function string(): Str;

    /**
     * Extract iterable property.
     * @return Arrayee<int|string, mixed>|ArrayMap<string, mixed>|Set<mixed>
     * @throws EvaluatingSubjectException
     */
    public function collection(): Collection;

    /**
     * Extract property which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     * @throws EvaluatingSubjectException
     */
    public function interface(string $interface): mixed;

    /**
     * Get subject name.
     */
    public function name(): string;
}
