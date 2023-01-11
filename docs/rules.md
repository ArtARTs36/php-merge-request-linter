# Available Rules

Currently is available that rules:

| # | Name | Class | Description |
| ------------ | ------------ | ------------ | ------------ |
| 1 | @mr-linter/changed_files_limit | ArtARTs36\MergeRequestLinter\Rule\ChangedFilesLimitRule | Check count changed files on a {limit}. |
| 2 | @mr-linter/description_contains_links_of_any_domains | ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinkOfAnyDomainsRule | Merge Request must contain links of any {domains}. |
| 3 | @mr-linter/description_contains_links_of_all_domains | ArtARTs36\MergeRequestLinter\Rule\DescriptionContainsLinksOfAllDomainsRule | Merge Request must contain links of all {domains}. |
| 4 | @mr-linter/description_not_empty | ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule | Description must fill. |
| 5 | @mr-linter/has_all_labels | ArtARTs36\MergeRequestLinter\Rule\HasAllLabelsOfRule | Merge Request must have all {labels} |
| 6 | @mr-linter/has_any_labels_of | ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule | Merge Request must have any {labels}. |
| 7 | @mr-linter/has_any_labels | ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule | Merge Request must have any labels. |
| 8 | @mr-linter/has_changes | ArtARTs36\MergeRequestLinter\Rule\HasChangesRule | Merge Request must have changes in {files}. |
| 9 | @mr-linter/jira/has_issue_link | ArtARTs36\MergeRequestLinter\Rule\HasLinkToJiraTaskRule | The description must have a link to Jira on a {domain} with {projectCode}. |
| 10 | @mr-linter/youtrack/has_issue_link | ArtARTs36\MergeRequestLinter\Rule\HasLinkToYouTrackIssueRule | The description must have a link to YouTrack issue on a {domain} with {projectCode}. |
| 11 | @mr-linter/title_matches_expression | ArtARTs36\MergeRequestLinter\Rule\TitleMatchesExpressionRule | The title must match the expression: {regex} |
| 12 | @mr-linter/title_must_starts_with_any_prefix | ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule | The title must starts with any {prefixes} |