<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Constructor for Rule.
 */
interface RuleConstructor
{
    /**
     * Get required params.
     * @return array<string, string|class-string>
     */
    public function params(): array;

    /**
     * Create Rule instance.
     * @param array<string, mixed> $args
     */
    public function construct(array $args): Rule;
}
