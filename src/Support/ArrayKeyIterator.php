<?php

namespace ArtARTs36\MergeRequestLinter\Support;

class ArrayKeyIterator extends \ArrayIterator
{
    public function current(): mixed
    {
        return $this->key();
    }
}
