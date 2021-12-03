<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class CallableRule extends SimpleRule implements Rule
{
    public function __construct(protected \Closure $callback, protected string $definition)
    {
        parent::__construct($definition);
    }

    protected function doLint(MergeRequest $request): bool|array|null
    {
        $callback = $this->callback;

        return $callback($request);
    }
}
