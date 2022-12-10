<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;

final class DefaultRules
{
    /** @var array<class-string<Rule>> */
    public const RULES = [
        ChangedFilesLimitRule::class,
        DescriptionContainsLinkOfAnyDomainsRule::class,
        DescriptionContainsLinksOfAllDomainsRule::class,
        DescriptionNotEmptyRule::class,
        HasAllLabelsOfRule::class,
        HasAnyLabelsRule::class,
        HasAnyLabelsOfRule::class,
        HasLinkToJiraTaskRule::class,
        HasLinkToYouTrackIssueRule::class,
        TitleMatchesExpressionRule::class,
        TitleStartsWithAnyPrefixRule::class,
        WhenHasLabelMustDescriptionContainsLinkOfAnyDomainsRule::class,
        WhenHasLabelMustTitleStartsWithRule::class,
    ];

    private function __construct()
    {
    }
}
