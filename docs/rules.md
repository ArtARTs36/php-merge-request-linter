# Validation rules

The following rules are available:

| Name | Description |
| ------------ | ------------ |
| @mr-linter/changed_files_limit | Check count changed files on a {limit}. |
| @mr-linter/description_contains_links_of_any_domains | Merge Request must contain links of any {domains}. |
| @mr-linter/description_contains_links_of_all_domains | Merge Request must contain links of all {domains}. |
| @mr-linter/description_not_empty | The description must be filled. |
| @mr-linter/has_all_labels | Merge Request must have all {labels} |
| @mr-linter/has_any_labels | Merge Request must have any {labels}. |
| @mr-linter/jira/has_issue_link | The description must have a link to Jira on a {domain} with {projectCode}. |
| @mr-linter/youtrack/has_issue_link | The description must have a link to YouTrack issue on a {domain} with {projectCode}. |
| @mr-linter/title_must_starts_with_any_prefix | The title must starts with any {prefixes} |
| @mr-linter/has_changes | Merge Request must have {changes}. |
| @mr-linter/title_starts_with_task_number | Title must starts with task number of project {projectCodes}. Mask: {projectCode}-number |
| @mr-linter/branch_starts_with_task_number | Source branch must starts with task number of project {projectCodes}. Mask: {projectCode}-number |
| @mr-linter/forbid_changes | Forbid changes for files. |
| @mr-linter/changelog_has_new_release | Changelog must be contained new release. |
| @mr-linter/diff_limit | The request must contain no more than {linesMax} changes. |
| @mr-linter/no_ssh_keys | Prevent ssh keys from being included in the merge request. |
| @mr-linter/disable_file_extensions | Disable adding files of certain extensions. |
| @mr-linter/title_conventional | The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0. |
| @mr-linter/description_template | The description must match defined template. Available placeholders: {text}, {text_multiline}, {number}, {word}, {release_tag} |

## Global parameters

| Name     | Description                                                                                                                          | Type    | Default value |
|----------|--------------------------------------------------------------------------------------------------------------------------------------|---------|---------------|
| critical | when `critical = true` the pipeline will fall <br/> when `critical = false` the pipeline will not fall, the error will be suppressed | boolean | false         |
| when     | conditions for triggering the rule                                                                                                   | object  | null          |


## @mr-linter/changed_files_limit

Check count changed files on a {limit}.

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| limit | Number of maximum possible changes | integer  | true |  |

## @mr-linter/description_contains_links_of_any_domains

Merge Request must contain links of any {domains}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domains | Array of domains | array  of strings  | true |  |  &quot;host.name&quot;  |

## @mr-linter/description_contains_links_of_all_domains

Merge Request must contain links of all {domains}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domains | Array of domains | array  of strings  | true |  |  &quot;host.name&quot;  |

## @mr-linter/description_not_empty

The description must be filled.


## @mr-linter/has_all_labels

Merge Request must have all {labels}

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| labels | Array of labels | array  of strings  | true |  |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/has_any_labels

Merge Request must have any {labels}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| labels | Array of labels | array  of strings  | true |  |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/jira/has_issue_link

The description must have a link to Jira on a {domain} with {projectCode}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domain | Domain of Jira instance | string  | true |  |  &quot;jira.my-company.com&quot;  |
| projectCodes | Project code | array  of strings  | false |  |  &quot;ABC&quot;  |

## @mr-linter/youtrack/has_issue_link

The description must have a link to YouTrack issue on a {domain} with {projectCode}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| domain | Domain hosting the YouTrack instance | string  | true |  |  &quot;yt.my-company.ru&quot;  |
| projectCodes | Project code | array  of strings  | false |  |  &quot;PORTAL&quot;  |

## @mr-linter/title_must_starts_with_any_prefix

The title must starts with any {prefixes}

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| prefixes | Array of prefixes | array  of strings  | true |  |

## @mr-linter/has_changes

Merge Request must have {changes}.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| changes | Array of need changes | array  of objects  | true |  |  |
| changes.* | Array of need changes | array  of objects  | true |  none  |  |
| changes.*.file | Relative path to file | string  | true |  |  &quot;file.txt&quot;  |
| changes.*.contains | Check contains string | string  | false |  |  |
| changes.*.containsRegex | Check contains by regex | string  | false |  |  |
| changes.*.updatedPhpConstant | Check contains updated PHP constant | string  | false |  |  &quot;VERSION&quot;  |

## @mr-linter/title_starts_with_task_number

Title must starts with task number of project {projectCodes}. Mask: {projectCode}-number

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false |  |  &quot;ABC&quot;  |

## @mr-linter/branch_starts_with_task_number

Source branch must starts with task number of project {projectCodes}. Mask: {projectCode}-number

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false |  |  &quot;ABC&quot;  |

## @mr-linter/forbid_changes

Forbid changes for files.

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| files | A set of files forbidden to be changed. | array  of strings  | true |  |

## @mr-linter/changelog_has_new_release

Changelog must be contained new release.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| file | Relative path to changelog file | string  | false |  |  &quot;CHANGELOG.md&quot;  |
| changes | Configuration for changes reading | object  | false |  |  |
| changes.types | Set of allowed change types | array  | false | `[Added, Changed, Deprecated, Removed, Fixed, Security]`  |  |

## @mr-linter/diff_limit

The request must contain no more than {linesMax} changes.

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| linesMax | Maximum allowed number of changed lines | integer  | false |  |
| fileLinesMax | Maximum allowed number of changed lines in a file | integer  | false |  |

## @mr-linter/no_ssh_keys

Prevent ssh keys from being included in the merge request.

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| stopOnFirstFailure | When the value is true, the search will stop after the first found key | boolean  | true |  |

## @mr-linter/disable_file_extensions

Disable adding files of certain extensions.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| extensions | Array of file extensions | array  of strings  | true |  |  &quot;pem&quot;,  &quot;pub&quot;,  &quot;php&quot;  |

## @mr-linter/title_conventional

The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0.

### Parameters

| Name | Description | Type | Required | Default value | Examples |
|------|-------------|------|----------|---------------|----------|
| types | Commit types | array  of strings  | false | `[build, chore, ci, docs, feat, fix, perf, refactor, revert, style, test]`  |  &quot;build&quot;,  &quot;chore&quot;,  &quot;ci&quot;,  &quot;docs&quot;,  &quot;feat&quot;,  &quot;fix&quot;,  &quot;perf&quot;,  &quot;refactor&quot;,  &quot;revert&quot;,  &quot;style&quot;,  &quot;test&quot;  |
| task | Check if title contains task number | object  | false | NULL  |  |
| task.projectCodes | Project codes. Empty list allowed for any projects | array  of strings  | false |  |  &quot;ABC&quot;  |

## @mr-linter/description_template

The description must match defined template. Available placeholders: {text}, {text_multiline}, {number}, {word}, {release_tag}

### Parameters

| Name | Description | Type | Required | Default value |
|------|-------------|------|----------|---------------|
| template | Template for description | string  | true |  |
| definition | Custom definition | string  | false | NULL  |
