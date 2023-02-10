<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
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
