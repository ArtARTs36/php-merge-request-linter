<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

#[\Attribute(\Attribute::TARGET_CLASS)]
class TestFor
{
    /**
     * @param class-string $class
     */
    public function __construct(
        public readonly string $class,
    ) {
        //
    }
}
