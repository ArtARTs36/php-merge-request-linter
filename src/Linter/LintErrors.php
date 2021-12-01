<?php

namespace ArtARTs36\MergeRequestLinter\Linter;

class LintErrors implements \IteratorAggregate, \Countable
{
    public function __construct(protected array $errors)
    {
        //
    }

    public function count(): int
    {
        return count($this->errors);
    }

    /**
     * @return iterable<LintError>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->errors);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }
}
