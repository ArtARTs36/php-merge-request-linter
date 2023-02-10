<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

/**
 * Rule Definition
 */
interface RuleDefinition
{
    /**
     * Get rule description
     */
    public function getDescription(): string;

    /**
     * Get rule description
     */
    public function __toString(): string;
}
