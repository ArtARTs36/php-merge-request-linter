# Validation rules

Currently is available that rules:

<table class="iksweb">
	<tbody>
		<tr>
			<td>Rule</td>
			<td>Description</td>
			<td colspan="3">Parameters</td>
		</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/changed_files_limit</td>
<td>limit</td>
<td>Number of maximum possible changes</td>
<td>integer</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/description_contains_links_of_any_domains</td>
<td>domains</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/description_contains_links_of_all_domains</td>
<td>domains</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/description_not_empty</td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/has_all_labels</td>
<td>labels</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/has_any_labels</td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/has_any_labels_of</td>
<td>labels</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="2">@mr-linter/jira/has_issue_link</td>
<td>domain</td>
<td></td>
<td>string</td>
</tr>
<tr>
    <td>projectCode</td>
    <td></td>
    <td>string</td>
</tr>
<tr>
<td colspan="2" rowspan="2">@mr-linter/youtrack/has_issue_link</td>
<td>domain</td>
<td>Domain hosting the YouTrack instance</td>
<td>string</td>
</tr>
<tr>
    <td>projectCode</td>
    <td>Project code</td>
    <td>string</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/title_must_starts_with_any_prefix</td>
<td>prefixes</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/has_changes</td>
<td>changes</td>
<td></td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/title_starts_with_task_number</td>
<td>projectName</td>
<td>Project name</td>
<td>string</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/branch_starts_with_task_number</td>
<td>projectName</td>
<td></td>
<td>string</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/forbid_changes</td>
<td>files</td>
<td>A set of files forbidden to be changed.</td>
<td>array</td>
</tr>
<tr>
<td colspan="2" rowspan="2">@mr-linter/update_changelog</td>
<td>file</td>
<td>Relative path to changelog file</td>
<td>string</td>
</tr>
<tr>
    <td>tags</td>
    <td>Tags parsing options</td>
    <td>object</td>
</tr>
<tr>
<td colspan="2" rowspan="2">@mr-linter/diff_limit</td>
<td>linesMax</td>
<td>Maximum allowed number of changed lines</td>
<td>integer</td>
</tr>
<tr>
    <td>fileLinesMax</td>
    <td>Maximum allowed number of changed lines in a file</td>
    <td>integer</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/no_ssh_keys</td>
<td>stopOnFirstFailure</td>
<td></td>
<td>boolean</td>
</tr>
<tr>
<td colspan="2" rowspan="1">@mr-linter/disable_file_extensions</td>
<td>extensions</td>
<td>array of file extensions</td>
<td>array</td>
</tr>
</tbody>
</table>
