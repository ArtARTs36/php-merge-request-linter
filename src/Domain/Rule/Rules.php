<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Rule;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

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

    public function implodeNames(string $sep): string
    {
        $str = '';

        foreach ($this->items as $item) {
            $str .= $item->getName();

            if (next($this->items) !== false) {
                $str .= $sep;
            }
        }

        return $str;
    }
}
