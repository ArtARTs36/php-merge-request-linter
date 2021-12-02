<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule implements Rule
{
    public function __construct(
        protected DescriptionContainsLinkOfAnyDomainsRule $domainsRule,
        protected $label,
    ) {
        //
    }

    public static function make(string $label, array $domains): self
    {
        return new self(DescriptionContainsLinkOfAnyDomainsRule::make($domains), $label);
    }

    public function lint(MergeRequest $request): array
    {
        if ($request->labels->missing($this->label)) {
            return [];
        }

        return $this->domainsRule->lint($request);
    }

    public function getDefinition(): string
    {
        return "When there is a label \"$this->label\" -> " . $this->domainsRule->getDefinition();
    }
}
