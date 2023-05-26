<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Instantiator;

use ArtARTs36\MergeRequestLinter\Shared\Reflector\Parameter;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Type;

/**
 * Instantiator for class.
 * @template T of object
 */
interface Instantiator
{
    /**
     * Get required params.
     * @return array<string, Parameter>
     */
    public function params(): array;

    /**
     * Create Rule instance.
     * @param array<string, mixed> $args
     * @return T
     */
    public function instantiate(array $args): object;
}
