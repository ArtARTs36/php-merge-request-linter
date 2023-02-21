<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectException;

/**
 * Property Extractor.
 */
interface PropertyExtractor
{
    /**
     * Extract scalar property.
     * @throws EvaluatingSubjectException
     */
    public function scalar(object $object, string $property): int|string|float|bool;

    /**
     * Extract property which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     * @throws EvaluatingSubjectException
     */
    public function interface(object $object, string $property, string $interface): mixed;
}
