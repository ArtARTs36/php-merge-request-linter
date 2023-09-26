<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule\TitleConventionalRule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

/**
 * @codeCoverageIgnore
 */
final class DefaultRules
{
    /** @var array<string, class-string<Rule>> */
    public static array $rules = [
        ChangedFilesLimitRule::NAME => ChangedFilesLimitRule::class,
        DescriptionContainsLinkOfAnyDomainsRule::NAME => DescriptionContainsLinkOfAnyDomainsRule::class,
        DescriptionContainsLinksOfAllDomainsRule::NAME => DescriptionContainsLinksOfAllDomainsRule::class,
        DescriptionNotEmptyRule::NAME => DescriptionNotEmptyRule::class,
        HasAnyLabelsRule::NAME => HasAnyLabelsRule::class,
        HasLinkToJiraTaskRule::NAME => HasLinkToJiraTaskRule::class,
        HasLinkToYouTrackIssueRule::NAME => HasLinkToYouTrackIssueRule::class,
        TitleStartsWithAnyPrefixRule::NAME => TitleStartsWithAnyPrefixRule::class,
        HasChangesRule::NAME => HasChangesRule::class,
        CustomRule::NAME => CustomRule::class,
        TitleStartsWithTaskNumberRule::NAME => TitleStartsWithTaskNumberRule::class,
        BranchStartsWithTaskNumberRule::NAME => BranchStartsWithTaskNumberRule::class,
        ForbidChangesRule::NAME => ForbidChangesRule::class,
        ChangelogHasNewReleaseRule::NAME => ChangelogHasNewReleaseRule::class,
        DiffLimitRule::NAME => DiffLimitRule::class,
        NoSshKeysRule::NAME => NoSshKeysRule::class,
        DisableFileExtensionsRule::NAME => DisableFileExtensionsRule::class,
        TitleConventionalRule::NAME => TitleConventionalRule::class,
        DescriptionTemplateRule::NAME => DescriptionTemplateRule::class,
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
