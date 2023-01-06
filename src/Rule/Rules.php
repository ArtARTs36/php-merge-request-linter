<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;

/**
 * @template-extends Arrayee<int, Rule>
 */
class Rules extends Arrayee
{
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
        $this->items[] = $rule;

        $this->count++;

        return $this;
    }
}
