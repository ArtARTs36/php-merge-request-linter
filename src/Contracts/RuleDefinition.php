<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

/**
 * Rule Definition
 * @method string getName - removed in 0.2.0
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
