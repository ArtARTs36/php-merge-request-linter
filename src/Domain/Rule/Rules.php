<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

/**
 * Interface for Collection of Rules.
 * @template-extends \Traversable<int, Rule>
 */
interface Rules extends \Traversable, \Countable
{
    /**
     * Add Rule to Collection.
     */
    public function add(Rule $rule): self;

    /**
     * Implode names of rules to string.
     */
    public function implodeNames(string $sep): string;
}
