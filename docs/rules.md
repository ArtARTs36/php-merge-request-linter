# Validation rules

Currently is available that rules:

| Name | Description |
| ------------ | ------------ |
| @mr-linter/changed_files_limit | Check count changed files on a {limit}. |
| @mr-linter/description_contains_links_of_any_domains | Merge Request must contain links of any {domains}. |
| @mr-linter/description_contains_links_of_all_domains | Merge Request must contain links of all {domains}. |
| @mr-linter/description_not_empty | The description must be filled. |
| @mr-linter/has_all_labels | Merge Request must have all {labels} |
| @mr-linter/has_any_labels | Merge Request must have any labels. |
| @mr-linter/has_any_labels_of | Merge Request must have any {labels}. |
| @mr-linter/jira/has_issue_link | The description must have a link to Jira on a {domain} with {projectCode}. |
| @mr-linter/youtrack/has_issue_link | The description must have a link to YouTrack issue on a {domain} with {projectCode}. |
| @mr-linter/title_must_starts_with_any_prefix | The title must starts with any {prefixes} |
| @mr-linter/has_changes | Merge Request must have changes in {files}. |
| @mr-linter/title_starts_with_task_number | Title must starts with task number of project {projectCodes}. Mask: {projectCode}-number |
| @mr-linter/branch_starts_with_task_number | Source branch must starts with task number of project {projectCodes}. Mask: {projectCode}-number |
| @mr-linter/forbid_changes | Forbid changes for files. |
| @mr-linter/update_changelog | Changelog must be contained new tag. |
| @mr-linter/diff_limit | The request must contain no more than {linesMax} changes. |
| @mr-linter/no_ssh_keys | Prevent ssh keys from being included in the merge request. |
| @mr-linter/disable_file_extensions | Disable adding files of certain extensions. |
| @mr-linter/title_conventional | The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0. |

## Global parameters

| Name     | Description                                                                                                                          | Type    |
|----------|--------------------------------------------------------------------------------------------------------------------------------------|---------|
| critical | when `critical = true` the pipeline will fall <br/> when `critical = false` the pipeline will not fall, the error will be suppressed | boolean |
| when     | conditions for triggering the rule                                                                                                   | object  |


## @mr-linter/changed_files_limit

Check count changed files on a {limit}.

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| limit | Number of maximum possible changes | integer  | true | none |

## @mr-linter/description_contains_links_of_any_domains

Merge Request must contain links of any {domains}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domains | Array of domains | array  of strings  | true | none |  &quot;host.name&quot;  |

## @mr-linter/description_contains_links_of_all_domains

Merge Request must contain links of all {domains}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domains | Array of domains | array  of strings  | true | none |  &quot;host.name&quot;  |

## @mr-linter/description_not_empty

The description must be filled.


## @mr-linter/has_all_labels

Merge Request must have all {labels}

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| labels | Array of labels | array  of strings  | true | none |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/has_any_labels

Merge Request must have any labels.


## @mr-linter/has_any_labels_of

Merge Request must have any {labels}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| labels | Array of labels | array  of strings  | true | none |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/jira/has_issue_link

The description must have a link to Jira on a {domain} with {projectCode}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domain | Domain of Jira instance | string  | true | none |  &quot;jira.my-company.com&quot;  |
| projectCodes | Project code | array  of strings  | false | none |  &quot;ABC&quot;  |

## @mr-linter/youtrack/has_issue_link

The description must have a link to YouTrack issue on a {domain} with {projectCode}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domain | Domain hosting the YouTrack instance | string  | true | none |  &quot;yt.my-company.ru&quot;  |
| projectCodes | Project code | array  of strings  | false | none |  &quot;PORTAL&quot;  |

## @mr-linter/title_must_starts_with_any_prefix

The title must starts with any {prefixes}

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| prefixes | Array of prefixes | array  of strings  | true | none |

## @mr-linter/has_changes

Merge Request must have changes in {files}.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| changes | Array of need changes | array  of objects  | true | none |  |
| changes.* | Array of need changes | array  of objects  | true | none |  |
| changes.*.file | Relative path to file | string  | true | none |  &quot;file.txt&quot;  |
| changes.*.contains | Check contains string | string  | false | none |  |
| changes.*.containsRegex | Check contains by regex | string  | false | none |  |
| changes.*.updatedPhpConstant | Check contains updated PHP constant | string  | false | none |  &quot;VERSION&quot;  |

## @mr-linter/title_starts_with_task_number

Title must starts with task number of project {projectCodes}. Mask: {projectCode}-number

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false | none |  &quot;ABC&quot;  |

## @mr-linter/branch_starts_with_task_number

Source branch must starts with task number of project {projectCodes}. Mask: {projectCode}-number

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false | none |  &quot;ABC&quot;  |

## @mr-linter/forbid_changes

Forbid changes for files.

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| files | A set of files forbidden to be changed. | array  of strings  | true | none |

## @mr-linter/update_changelog

Changelog must be contained new tag.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| file | Relative path to changelog file | string  | false | none |  &quot;CHANGELOG.md&quot;  |
| tags | Tags parsing options | object  | true | none |  |
| tags.heading | Headings parse options | object  | true | none |  |
| tags.heading.level | Markdown heading level for tags | int  | false | 2 |  1,  2,  3,  4,  5,  6  |

## @mr-linter/diff_limit

The request must contain no more than {linesMax} changes.

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| linesMax | Maximum allowed number of changed lines | integer  | false | none |
| fileLinesMax | Maximum allowed number of changed lines in a file | integer  | false | none |

## @mr-linter/no_ssh_keys

Prevent ssh keys from being included in the merge request.

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| stopOnFirstFailure | When the value is true, the search will stop after the first found key | boolean  | true | none |

## @mr-linter/disable_file_extensions

Disable adding files of certain extensions.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| extensions | Array of file extensions | array  of strings  | true | none |  &quot;pem&quot;,  &quot;pub&quot;,  &quot;php&quot;  |

## @mr-linter/title_conventional

The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0.

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| types | Commit types | array  of strings  | false | none |  &quot;build&quot;,  &quot;chore&quot;,  &quot;ci&quot;,  &quot;docs&quot;,  &quot;feat&quot;,  &quot;fix&quot;,  &quot;perf&quot;,  &quot;refactor&quot;,  &quot;revert&quot;,  &quot;style&quot;,  &quot;test&quot;  |
| task | Check if title contains task number | object  | false |  |  |
| task.projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false | none |  &quot;ABC&quot;  |
