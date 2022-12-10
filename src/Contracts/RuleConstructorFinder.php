<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

use ArtARTs36\MergeRequestLinter\Exception\ConstructorFindException;

/**
 * Constructor Finder for Rule
 */
interface RuleConstructorFinder
{
    /**
     * Find constructor for $class
     * @param class-string<Rule> $class
     * @throws ConstructorFindException
     */
    public function find(string $class): RuleConstructor;
}
