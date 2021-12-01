<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

class Rules implements \IteratorAggregate
{
    protected array $rules = [];

    public function add(Rule $rule): self
    {
        $this->rules[$rule::class] = $rule;

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
