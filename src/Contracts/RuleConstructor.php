<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

interface RuleConstructor
{
    /**
     * @return array<string, string|class-string>
     */
    public function params(): array;

    /**
     * @param array<string, mixed> $args
     */
    public function construct(array $args): Rule;
}
