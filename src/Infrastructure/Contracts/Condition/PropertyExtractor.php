<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectException;
use ArtARTs36\Str\Str;

/**
 * Property Extractor.
 */
interface PropertyExtractor
{
    /**
     * Extract numeric property.
     * @throws EvaluatingSubjectException
     */
    public function numeric(object $object, string $property): int|float;

    /**
     * Extract scalar property.
     * @throws EvaluatingSubjectException
     */
    public function scalar(object $object, string $property): int|string|float|bool;

    /**
     * Extract string property.
     * @throws EvaluatingSubjectException
     */
    public function string(object $object, string $property): Str;

    /**
     * Extract property which implements $interface.
     * @template V
     * @param class-string<V> $interface
     * @return V
     * @throws EvaluatingSubjectException
     */
    public function interface(object $object, string $property, string $interface): mixed;
}
