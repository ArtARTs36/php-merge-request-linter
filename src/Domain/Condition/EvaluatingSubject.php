<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

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
