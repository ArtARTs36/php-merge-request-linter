<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;

/**
 * @template-implements \IteratorAggregate<Rule>
 */
class Rules implements \IteratorAggregate
{
    /**
     * @param array<Rule> $rules
     */
    public function __construct(protected array $rules)
    {
        //
    }

    /**
     * @param iterable<Rule> $rules
     */
    public static function make(iterable $rules): self
    {
        $instance = new self([]);

        foreach ($rules as $rule) {
            $instance->add($rule);
        }

        return $instance;
    }

    public function add(Rule $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * @return iterable<Rule>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->rules);
    }
}
