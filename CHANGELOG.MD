# CHANGELOG for Merge Request Linter

This file contains changelogs.

v0.9.0
--------------------
#### Added
* Markdown condition: containsHeading
* `linesMax` condition
* `containsLine` condition

#### Changed
* Refactored condition evaluator resolving

v0.8.1
--------------------
#### Fixed
* Fixed `NativeJsonDecoder`

#### Added
* Some tests

v0.8.0
--------------------
#### Changed
* MR-Linter is now not **library**, but **project**
* Project structure

#### Added
* Added `IsSnakeCaseEvaluator`
* Added `IsKebabCaseEvaluator`
* Added `IsCamelCaseEvaluator`
* Added `IsStudlyCaseEvaluator`
* Added `IsLowerCaseEvaluator`
* Added `IsUpperCaseEvaluator`
* Added `$all` evaluator
* Added `$any` evaluator
* Added `IsEmptyEvaluator`

#### Removed
* PHP Config Loader

v0.7.11
--------------------
#### Added
* Added Custom rule for user conditions

v0.7.10
--------------------
#### Added
* Added dependency check

#### Fixed
* Fixed direct dependencies

v0.7.9
--------------------
#### Added
* Added condition `match` for chechking string on match regex.

v0.7.8
--------------------
#### Added
* Added coverage reporting
* Added some tests

v0.7.8
--------------------
#### Added
* Added coverage reporting
* Added some tests

v0.7.7
--------------------
#### Added
* Added `notStarts` Condition Operator
* Added `notEnds` Condition Operator

v0.7.6
--------------------
#### Added
* Added interface `HasDebugInfo` for better object printing.

v0.7.5
--------------------
#### Moved
* Moved exception on building guzzle client to ClientFactory

#### Fixed
* Command `dump`: print concrete rule class

#### Removed
* Static class URI

v0.7.4
--------------------
#### Added
* Added command `mr-linter install`: Copy config into yaml, json files

v0.7.3
--------------------
#### Changed
* Configuration loading refactoring

v0.7.2
--------------------
#### Added
* Support many configurations for Rule
* Condition Operator 'countEqualsAny'

v0.7.1
--------------------
#### Added
* Deptrac
* Contracts for YAML/JSON decoding.

v0.7.0
--------------------
#### Added
* Metrics
* Debug mode, `mr-linter lint --debug`
* Logging for HTTP Requests

v0.6.0
--------------------
#### Added
* Added Rule **HasChanges**
* Added ApplicationFactory
* Added InfoCommand `mr-linter info`
* Added conditions `countEquals`, `countNotEquals`

v0.5.1
--------------------
#### Fixed
* [Bug] Credentials are required to be filled

v0.5.0
--------------------
#### Added
* YAML Config Loader

v0.4.0
--------------------
#### Added
* Rule conditions

v0.3.0
--------------------
#### Added
* Loading Config from JSON
* Docker image

v0.2.0
--------------------
#### Added
* Added method `getName` to Rule

v0.1.5
--------------------
#### Fixed
* Fix finding composer autoload path in binary

v0.1.4
--------------------
#### Added
* Added rule for check count changed files on a limit
* Added property “changedFilesCount” to merge request objects

v0.1.3
--------------------
#### Changed
* Update exception hierarchy. Parent: MergeRequestLinterException

#### Added
* Added `ServerUnexpectedResponseException`

v0.1.2
--------------------
#### Added
* [Feature] Added rule "Has link to YouTrack issue"
* [Feature] Added rule "OnTargetBranchRule"
* Added property "sourceBranch" to MergeRequest object
* Added property "targetBranch" to MergeRequest object

v0.1.1
--------------------
#### Addded
* [Feature] Added rule "Has link to Jira task"

v0.1.0
--------------------
* Init library
