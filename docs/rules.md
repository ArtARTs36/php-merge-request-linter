# Validation rules

Currently is available that rules:

| Name | Description | Parameters |
| ------------ | ------------ | ------------ |
| @mr-linter/changed_files_limit | Check count changed files on a {limit}. | `limit` - integer   <br/>  |
| @mr-linter/description_contains_links_of_any_domains | Merge Request must contain links of any {domains}. | `domains` - array  of strings   <br/>  |
| @mr-linter/description_contains_links_of_all_domains | Merge Request must contain links of all {domains}. | `domains` - array  of strings   <br/>  |
| @mr-linter/description_not_empty | Description must be filled. | None  |
| @mr-linter/has_all_labels | Merge Request must have all {labels} | `labels` - array  of strings   <br/>  |
| @mr-linter/has_any_labels | Merge Request must have any labels. | None  |
| @mr-linter/has_any_labels_of | Merge Request must have any {labels}. | `labels` - array  of strings   <br/>  |
| @mr-linter/jira/has_issue_link | The description must have a link to Jira on a {domain} with {projectCode}. | `domain` - string   <br/>  `projectCode` - string   <br/>  |
| @mr-linter/youtrack/has_issue_link | The description must have a link to YouTrack issue on a {domain} with {projectCode}. | `domain` - string   <br/>  `projectCode` - string   <br/>  |
| @mr-linter/title_must_starts_with_any_prefix | The title must starts with any {prefixes} | `prefixes` - array  of strings   <br/>  |
| @mr-linter/has_changes | Merge Request must have changes in {files}. | `changes` - array   <br/>  |
| @mr-linter/title_starts_with_task_number | Title must starts with task number of project {projectName}. Mask: {projectName}-number | `projectName` - string   <br/>  |

## Rule "@mr-linter/changed_files_limit"
Check count changed files on a {limit}.
### Tests
#### Case №1
Merge request properties:
- changes: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1]

Rule values:
- limit: 5

Expected state: false

#### Case №2
Merge request properties:
- changes: [1, 1, 1, 1, 1]

Rule values:
- limit: 10

Expected state: true

## Rule "@mr-linter/description_contains_links_of_any_domains"
Merge Request must contain links of any {domains}.
### Tests
## Rule "@mr-linter/description_contains_links_of_all_domains"
Merge Request must contain links of all {domains}.
### Tests
## Rule "@mr-linter/description_not_empty"
Description must be filled.
### Tests
## Rule "@mr-linter/has_all_labels"
Merge Request must have all {labels}
### Tests
## Rule "@mr-linter/has_any_labels"
Merge Request must have any labels.
### Tests
## Rule "@mr-linter/has_any_labels_of"
Merge Request must have any {labels}.
### Tests
## Rule "@mr-linter/jira/has_issue_link"
The description must have a link to Jira on a {domain} with {projectCode}.
### Tests
## Rule "@mr-linter/youtrack/has_issue_link"
The description must have a link to YouTrack issue on a {domain} with {projectCode}.
### Tests
## Rule "@mr-linter/title_must_starts_with_any_prefix"
The title must starts with any {prefixes}
### Tests
## Rule "@mr-linter/has_changes"
Merge Request must have changes in {files}.
### Tests
## Rule "@mr-linter/title_starts_with_task_number"
Title must starts with task number of project {projectName}. Mask: {projectName}-number
### Tests
#### Case №1
Merge request properties:
- title: TASK-1 project

Rule values:
- projectName: TASK

Expected state: true

#### Case №2
Merge request properties:
- title: TASK- project

Rule values:
- projectName: TASK

Expected state: false

#### Case №3
Merge request properties:
- title: AB TASK-1 project

Rule values:
- projectName: TASK

Expected state: false

