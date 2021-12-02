<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Rule Definition
 */
interface RuleDefinition
{
    /**
     * Get rule description
     */
    public function getDescription(): string;
}
