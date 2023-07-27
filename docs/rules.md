# Validation rules

Currently is available that rules:

| Name | Description | Parameters |
| ------------ | ------------ | ------------ |
| @mr-linter/changed_files_limit | Check count changed files on a {limit}. | `limit` - integer   <br/>  |
| @mr-linter/description_contains_links_of_any_domains | Merge Request must contain links of any {domains}. | `domains` - array  of strings   <br/>  |
| @mr-linter/description_contains_links_of_all_domains | Merge Request must contain links of all {domains}. | `domains` - array  of strings   <br/>  |
| @mr-linter/description_not_empty | The description must be filled. | None  |
| @mr-linter/has_all_labels | Merge Request must have all {labels} | `labels` - array  of strings   <br/>  |
| @mr-linter/has_any_labels | Merge Request must have any labels. | None  |
| @mr-linter/has_any_labels_of | Merge Request must have any {labels}. | `labels` - array  of strings   <br/>  |
| @mr-linter/jira/has_issue_link | The description must have a link to Jira on a {domain} with {projectCode}. | `domain` - string   <br/>  `projectCode` - string   <br/>  |
| @mr-linter/youtrack/has_issue_link | The description must have a link to YouTrack issue on a {domain} with {projectCode}. | `domain` - string   <br/>  `projectCode` - string   <br/>  |
| @mr-linter/title_must_starts_with_any_prefix | The title must starts with any {prefixes} | `prefixes` - array  of strings   <br/>  |
| @mr-linter/has_changes | Merge Request must have changes in {files}. | `changes` - array  of objects   <br/>  |
| @mr-linter/title_starts_with_task_number | Title must starts with task number of project {projectName}. Mask: {projectName}-number | `projectName` - string   <br/>  |
| @mr-linter/branch_starts_with_task_number | Source branch must starts with task number of project {projectName}. Mask: {projectName}-number | `projectName` - string   <br/>  |
| @mr-linter/forbid_changes | Forbid changes for files. | `files` - array  of strings   <br/>  |
| @mr-linter/update_changelog | Changelog must be contained new tag. | `file` - string   <br/>  `tags` - object   <br/>  |
| @mr-linter/diff_limit | The request must contain no more than {linesMax} changes. | `linesMax` - integer   <br/>  `fileLinesMax` - integer   <br/>  |
