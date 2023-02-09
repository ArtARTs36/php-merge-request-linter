<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

final class DefaultRules
{
    /** @var array<string, class-string<Rule>> */
    public static array $rules = [
        ChangedFilesLimitRule::NAME => ChangedFilesLimitRule::class,
        DescriptionContainsLinkOfAnyDomainsRule::NAME => DescriptionContainsLinkOfAnyDomainsRule::class,
        DescriptionContainsLinksOfAllDomainsRule::NAME => DescriptionContainsLinksOfAllDomainsRule::class,
        DescriptionNotEmptyRule::NAME => DescriptionNotEmptyRule::class,
        HasAllLabelsOfRule::NAME => HasAllLabelsOfRule::class,
        HasAnyLabelsRule::NAME => HasAnyLabelsRule::class,
        HasAnyLabelsOfRule::NAME => HasAnyLabelsOfRule::class,
        HasLinkToJiraTaskRule::NAME => HasLinkToJiraTaskRule::class,
        HasLinkToYouTrackIssueRule::NAME => HasLinkToYouTrackIssueRule::class,
        TitleStartsWithAnyPrefixRule::NAME => TitleStartsWithAnyPrefixRule::class,
        HasChangesRule::NAME => HasChangesRule::class,
        CustomRule::NAME => CustomRule::class,
    ];

    /**
     * @return ArrayMap<string, class-string<Rule>>
     */
    public static function map(): ArrayMap
    {
        return new ArrayMap(self::$rules);
    }

    private function __construct()
    {
    }
}
