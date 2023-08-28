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
| @mr-linter/title_starts_with_task_number | Title must starts with task number of project {projectName}. Mask: {projectName}-number |
| @mr-linter/branch_starts_with_task_number | Source branch must starts with task number of project {projectName}. Mask: {projectName}-number |
| @mr-linter/forbid_changes | Forbid changes for files. |
| @mr-linter/update_changelog | Changelog must be contained new tag. |
| @mr-linter/diff_limit | The request must contain no more than {linesMax} changes. |
| @mr-linter/no_ssh_keys | Prevent ssh keys from being included in the merge request. |
| @mr-linter/disable_file_extensions | Disable adding files of certain extensions. |


## @mr-linter/changed_files_limit

Check count changed files on a {limit}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| limit | Number of maximum possible changes | integer   |  |

## @mr-linter/description_contains_links_of_any_domains

Merge Request must contain links of any {domains}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| domains | Array of domains | array  of strings   |  &quot;host.name&quot;  |

## @mr-linter/description_contains_links_of_all_domains

Merge Request must contain links of all {domains}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| domains | Array of domains | array  of strings   |  &quot;host.name&quot;  |

## @mr-linter/description_not_empty

The description must be filled.

## @mr-linter/has_all_labels

Merge Request must have all {labels}

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| labels | Array of labels | array  of strings   |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/has_any_labels

Merge Request must have any labels.

## @mr-linter/has_any_labels_of

Merge Request must have any {labels}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| labels | Array of labels | array  of strings   |  &quot;Feature&quot;,  &quot;Bug&quot;  |

## @mr-linter/jira/has_issue_link

The description must have a link to Jira on a {domain} with {projectCode}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| domain | Domain of Jira instance | string   |  &quot;jira.my-company.com&quot;  |
| projectCode | Project code | string   |  &quot;VIP&quot;,  &quot;SBD&quot;  |

## @mr-linter/youtrack/has_issue_link

The description must have a link to YouTrack issue on a {domain} with {projectCode}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| domain | Domain hosting the YouTrack instance | string   |  &quot;yt.my-company.ru&quot;  |
| projectCode | Project code | string   |  &quot;PORTAL&quot;  |

## @mr-linter/title_must_starts_with_any_prefix

The title must starts with any {prefixes}

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| prefixes | Array of prefixes | array  of strings   |  |

## @mr-linter/has_changes

Merge Request must have changes in {files}.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| changes | Array of need changes | array  of objects   <br/> See details in Config JSON Schema |  |

## @mr-linter/title_starts_with_task_number

Title must starts with task number of project {projectName}. Mask: {projectName}-number

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| projectName | Project name | string   |  |

## @mr-linter/branch_starts_with_task_number

Source branch must starts with task number of project {projectName}. Mask: {projectName}-number

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| projectName | Project name | string   |  &quot;VIP&quot;  |

## @mr-linter/forbid_changes

Forbid changes for files.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| files | A set of files forbidden to be changed. | array  of strings   |  |

## @mr-linter/update_changelog

Changelog must be contained new tag.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| file | Relative path to changelog file | string   |  |
| tags | Tags parsing options | object   |  |

## @mr-linter/diff_limit

The request must contain no more than {linesMax} changes.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| linesMax | Maximum allowed number of changed lines | integer   |  |
| fileLinesMax | Maximum allowed number of changed lines in a file | integer   |  |

## @mr-linter/no_ssh_keys

Prevent ssh keys from being included in the merge request.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| stopOnFirstFailure | When the value is true, the search will stop after the first found key | boolean   |  |

## @mr-linter/disable_file_extensions

Disable adding files of certain extensions.

| Name | Description | Type | Examples |
| ------------ | ------------ |------ | ------|
| extensions | Array of file extensions | array  of strings   |  &quot;pem&quot;,  &quot;pub&quot;,  &quot;php&quot;  |
