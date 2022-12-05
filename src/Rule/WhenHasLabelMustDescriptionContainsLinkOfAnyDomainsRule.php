<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * When has label must description contains link of any {domains}.
 */
class WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule extends AbstractRule implements Rule
{
    public const NAME = '@mr-linter/when_has_label_must_description_contains_link_of_any_domains';

    public function __construct(
        protected DescriptionContainsLinkOfAnyDomainsRule $domainsRule,
        protected string $label,
    ) {
        //
    }

    /**
     * @param iterable<string> $domains
     */
    public static function make(string $label, iterable $domains): self
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

    public function getDefinition(): RuleDefinition
    {
        return new Definition(
            "When there is a label \"$this->label\" -> " . $this->domainsRule->getDefinition()->getDescription()
        );
    }
}
