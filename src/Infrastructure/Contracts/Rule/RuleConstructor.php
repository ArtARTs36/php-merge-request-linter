<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Rule;

use ArtARTs36\MergeRequestLinter\Common\Reflector\ParameterType;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;

/**
 * Constructor for Rule.
 */
interface RuleConstructor
{
    /**
     * Get required params.
     * @return array<string, ParameterType>
     */
    public function params(): array;

    /**
     * Create Rule instance.
     * @param array<string, mixed> $args
     */
    public function construct(array $args): Rule;
}
