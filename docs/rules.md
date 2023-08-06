# Validation rules

Currently is available that rules:

<table>
	<tbody>
		<tr>
			<td>Rule</td>
			<td>Description</td>
			<td colspan="3">Parameters</td>
		</tr>
<tr>
<td rowspan="1">@mr-linter/changed_files_limit</td>
<td rowspan="1">Check count changed files on a {limit}.</td>
<td>limit</td>
<td>Number of maximum possible changes </td>
<td>integer</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/description_contains_links_of_any_domains</td>
<td rowspan="1">Merge Request must contain links of any {domains}.</td>
<td>domains</td>
<td>Array of domains </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="1">@mr-linter/description_contains_links_of_all_domains</td>
<td rowspan="1">Merge Request must contain links of all {domains}.</td>
<td>domains</td>
<td>Array of domains </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="1">@mr-linter/description_not_empty</td>
<td colspan="4">The description must be filled.</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/has_all_labels</td>
<td rowspan="1">Merge Request must have all {labels}</td>
<td>labels</td>
<td>Array of labels </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="1">@mr-linter/has_any_labels</td>
<td colspan="4">Merge Request must have any labels.</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/has_any_labels_of</td>
<td rowspan="1">Merge Request must have any {labels}.</td>
<td>labels</td>
<td>Array of labels </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="2">@mr-linter/jira/has_issue_link</td>
<td rowspan="2">The description must have a link to Jira on a {domain} with {projectCode}.</td>
<td>domain</td>
<td>Domain of Jira instance </td>
<td>string</td>
</tr>
<tr>
    <td>projectCode</td>
    <td>Project code </td>
    <td>string</td>
</tr>
<tr>
<td rowspan="2">@mr-linter/youtrack/has_issue_link</td>
<td rowspan="2">The description must have a link to YouTrack issue on a {domain} with {projectCode}.</td>
<td>domain</td>
<td>Domain hosting the YouTrack instance <br/> Examples:  &quot;yt.my-company.ru&quot; </td>
<td>string</td>
</tr>
<tr>
    <td>projectCode</td>
    <td>Project code <br/> Examples:  &quot;yt.my-company.ru&quot; </td>
    <td>string</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/title_must_starts_with_any_prefix</td>
<td rowspan="1">The title must starts with any {prefixes}</td>
<td>prefixes</td>
<td>Array of prefixes </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="1">@mr-linter/has_changes</td>
<td rowspan="1">Merge Request must have changes in {files}.</td>
<td>changes</td>
<td> </td>
<td>array of objects </td>
</tr>
<tr>
<td rowspan="1">@mr-linter/title_starts_with_task_number</td>
<td rowspan="1">Title must starts with task number of project {projectName}. Mask: {projectName}-number</td>
<td>projectName</td>
<td>Project name </td>
<td>string</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/branch_starts_with_task_number</td>
<td rowspan="1">Source branch must starts with task number of project {projectName}. Mask: {projectName}-number</td>
<td>projectName</td>
<td>Project name <br/> Examples:  &quot;VIP&quot; </td>
<td>string</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/forbid_changes</td>
<td rowspan="1">Forbid changes for files.</td>
<td>files</td>
<td>A set of files forbidden to be changed. </td>
<td>array of strings </td>
</tr>
<tr>
<td rowspan="2">@mr-linter/update_changelog</td>
<td rowspan="2">Changelog must be contained new tag.</td>
<td>file</td>
<td>Relative path to changelog file </td>
<td>string</td>
</tr>
<tr>
    <td>tags</td>
    <td>Tags parsing options </td>
    <td>object</td>
</tr>
<tr>
<td rowspan="2">@mr-linter/diff_limit</td>
<td rowspan="2">The request must contain no more than {linesMax} changes.</td>
<td>linesMax</td>
<td>Maximum allowed number of changed lines </td>
<td>integer</td>
</tr>
<tr>
    <td>fileLinesMax</td>
    <td>Maximum allowed number of changed lines in a file </td>
    <td>integer</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/no_ssh_keys</td>
<td rowspan="1">Prevent ssh keys from being included in the merge request.</td>
<td>stopOnFirstFailure</td>
<td>When the value is true, the search will stop after the first found key </td>
<td>boolean</td>
</tr>
<tr>
<td rowspan="1">@mr-linter/disable_file_extensions</td>
<td rowspan="1">Disable adding files of certain extensions.</td>
<td>extensions</td>
<td>array of file extensions <br/> Examples:  &quot;pem&quot;,  &quot;pub&quot;,  &quot;php&quot; </td>
<td>array of strings </td>
</tr>
</tbody>
</table>
