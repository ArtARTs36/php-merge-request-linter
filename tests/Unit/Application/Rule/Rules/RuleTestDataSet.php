<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

class RuleTestDataSet
{
    /**
     * @param array<string, mixed> $requestProperties
     * @param array<mixed> $ruleValues
     */
    public function __construct(
        public readonly array $requestProperties,
        public readonly array $ruleValues,
        public readonly bool $result,
    ) {
        //
    }
}
