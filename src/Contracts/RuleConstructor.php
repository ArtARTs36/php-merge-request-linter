<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Support\ParameterType;

/**
 * Constructor for Rule.
 */
interface RuleConstructor
{
    /**
     * Get required params.
     * @return array<string, ParameterType>
     */
    public function params(): array;

    /**
     * Create Rule instance.
     * @param array<string, mixed> $args
     */
    public function construct(array $args): Rule;
}
