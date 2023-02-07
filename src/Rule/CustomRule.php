<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\CustomRule\RulesExecutor;

class CustomRule extends AbstractRule
{
    public const NAME = 'custom';

    /**
     * @param array<string, array<string, mixed>> $rules
     */
    public function __construct(
        private readonly RulesExecutor $executor,
        private readonly array $rules,
        private readonly string $definition,
    ) {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $this->executor->execute($this->rules, $request);
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition($this->definition);
    }
}
