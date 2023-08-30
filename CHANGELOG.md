# Changelog

This file contains changelogs.

[View all Releases](https://github.com/ArtARTs36/php-merge-request-linter/releases)

-----------------------------------------------------------------

## [v0.17.0 (2023-08-30)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.16.4..0.17.0)

## Optimized
* Updated PHP to 8.2
* Deleted unless dependency "jetbrains/phpstorm-attributes"

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.17.0)

-----------------------------------------------------------------

## [v0.16.4 (2023-08-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.16.3..0.16.4)

## Added
* Throw exception when github actions token is empty
* Throw exception when gitlab token is empty

## Optimized
* Reduced docker image size

## Docs
* Updated rules doc page

## Dependencies
* Bump `guzzlehttp/psr7` from `2.4.3` to `2.4.5`

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.16.4)

-----------------------------------------------------------------

## [v0.16.3 (2023-08-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.16.2..0.16.3)

## Added
* Added rule `title_conventional`

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.16.3)

-----------------------------------------------------------------

## [v0.16.2 (2023-08-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.16.1..0.16.2)

## Optimized
* Throw http exceptions and catch their in CI requests

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.16.2)

-----------------------------------------------------------------

## [v0.16.1 (2023-08-13)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.16.0..0.16.1)

## Added
* Support GitLab CI job token

## Fixed
* Fixed phar on "TwigTest not found"

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.16.1)

-----------------------------------------------------------------

## [v0.16.0 (2023-08-06)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.15.3..0.16.0)

## Added
* Added comments with lint result for merge requests

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.16.0)

-----------------------------------------------------------------

## [v0.15.3 (2023-07-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.15.2..0.15.3)

## Added
* Added "no ssh keys" rule to prevent ssh keys from being included in the merge request.
* Added "disable file extensions" rule to disable adding files of certain extensions.

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.15.3)

-----------------------------------------------------------------

## [v0.15.2 (2023-07-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.15.1..0.15.2)

## Optimization
* Add diff fragments for fast search in changes

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.15.2)

-----------------------------------------------------------------

## [v0.15.1 (2023-07-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.15.0..0.15.1)

## Added
* Added Rule "diff limit"
* Added examples for params of rules

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.15.1)

-----------------------------------------------------------------

## [v0.15.0 (2023-05-30)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.14.1..0.15.0)

### Added
* Added rule "Update changelog"

### Internal
* Resolving object config for rule
* Refactored type resolvers

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.15.0)

-----------------------------------------------------------------

## [v0.14.1 (2023-05-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.14.0..0.14.1)

### Added
* Add Evaluator "Not starts any"
* Turn on forgotten rule "@mr-linter/forbid_changes"

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.14.1)


-----------------------------------------------------------------

## [v0.14.0 (2023-05-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.13.1..0.14.0)

## Added
* Suppress error on non-critical rules via rule option `critical: false`
* Added option `stop_on_failure` for stop linter on first failure
* Added option `stop_on_warning` for stop linter on first warning

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.14.0)


-----------------------------------------------------------------

## [v0.13.1 (2023-05-26)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.13.0..0.13.1)

### Added
* [Logger] Print date and time in logs
* Added array of notes in event `rule_was_failed`

### Internal
* [Docs] Added event descriptions into config JSON Schema

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.13.1)

-----------------------------------------------------------------

## [v0.13.0 (2023-05-25)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.12.1..0.13.0)

### Added
* Added option for disable notification sound by time period
* Added environment variable `MR_LINTER_TIMEZONE` for set timezone

### Changed
* Moved shared contracts from common folder to self folders

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.13.0)

-----------------------------------------------------------------

## [v0.12.1 (2023-05-22)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.12.0..0.12.1)

### Added
* Add evaluator "not has any"

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.12.1)

-----------------------------------------------------------------

## [v0.12.0 (2023-05-21)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.11.1..0.12.0)

### Added
* Add logs for HTTP Client
* Validate BitBucket PR data

## Changed
* Update PHPStan level to 9

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.12.0)

-----------------------------------------------------------------

## [v0.11.1 (2023-03-17)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.11.0..0.11.1)

### Added
* Added Rule "Branch starts with task number"
* Added Rule "Forbid changes"
* Added logs for events

### Internal
* Up test coverage

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.11.1)

-----------------------------------------------------------------

## [v0.11.0 (2023-03-14)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.10.1..0.11.0)

### Added
* Support Bitbucket Pipelines

### Changed
* Configuration structure for CI credentials

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.11.0)

-----------------------------------------------------------------

## [v0.10.1 (2023-03-01)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.10.0..0.10.1)

### Added
* Documentation for conditions
* Rule `@mr-linter/title_starts_with_task_number` for checking task number in request title

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.10.1)

-----------------------------------------------------------------

## [v0.10.0 (2023-02-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.9.0..0.10.0)

### Added
* Notifications for telegram on events: **lint_finished**, **lint_started**

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.10.0)

-----------------------------------------------------------------

## [v0.9.0 (2023-02-21)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.8.1..0.9.0)

### Added
* Added markdown condition operator: `containsHeading`
* Added condition operator: `linesMax`
* Added condition operator: `containsLine`

### Internal
* Refactored condition evaluator resolving
* 🚀 Up test coverage to 40.21%
* Add dependency **psr/clock**

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.9.0)

-----------------------------------------------------------------

## [v0.8.1 (2023-02-15)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.8.0..0.8.1)

### Fixed
* Fixed `NativeJsonDecoder`

### Internal
* Added some tests

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.8.1)

-----------------------------------------------------------------

## [v0.8.0 (2023-02-15)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.11..0.8.0)

### Changed
* MR-Linter is now not **library**, but **project**
* Project structure

### Added
* Added `IsSnakeCaseEvaluator`
* Added `IsKebabCaseEvaluator`
* Added `IsCamelCaseEvaluator`
* Added `IsStudlyCaseEvaluator`
* Added `IsLowerCaseEvaluator`
* Added `IsUpperCaseEvaluator`
* Added `$all` evaluator
* Added `$any` evaluator
* Added `IsEmptyEvaluator`

### Removed
* PHP Config Loader

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.8.0)

-----------------------------------------------------------------

## [v0.7.11 (2023-02-09)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.10..0.7.11)

### Added
* Added Custom rule for user conditions

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.11)

-----------------------------------------------------------------

## [v0.7.10 (2023-02-09)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.9..0.7.10)

### Added
* Added dependency check

### Fixed
* Fixed direct dependencies

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.10)

-----------------------------------------------------------------

## [v0.7.9 (2023-02-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.8..0.7.9)

### Added
* Added condition `match` for chechking string on match regex.

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.9)

-----------------------------------------------------------------

## [v0.7.8 (2023-02-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.7..0.7.8)

### Internal
* Added coverage reporting
* Added some tests

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.8)

-----------------------------------------------------------------

## [v0.7.7 (2023-02-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.6..0.7.7)

### Added
* Added `notStarts` Condition Operator
* Added `notEnds` Condition Operator

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.7)

-----------------------------------------------------------------

## [v0.7.6 (2023-02-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.5..0.7.6)

### Added
* Added interface `HasDebugInfo` for better object printing.

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.6)

-----------------------------------------------------------------

## [v0.7.5 (2023-02-03)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.4..0.7.5)

### Changed
* Moved exception on building guzzle client to ClientFactory
* Static class URI

### Fixed
* Command `dump`: print concrete rule class

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.5)

-----------------------------------------------------------------

## [v0.7.4 (2022-01-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.3..0.7.4)

### Added
* Added command `mr-linter install`: Copy config into yaml, json files

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.4)

-----------------------------------------------------------------

## [v0.7.3 (2022-01-16)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.2..0.7.3)

### Changed
* Configuration loading refactoring

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.3)

-----------------------------------------------------------------

## [v0.7.2 (2022-01-13)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.1..0.7.2)

### Added
* Support many configurations for Rule
* Condition Operator 'countEqualsAny'

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.2)

-----------------------------------------------------------------

## [v0.7.1 (2022-01-13)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.0..0.7.1)

### Internal
* Deptrac
* Contracts for YAML/JSON decoding.

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.1)

-----------------------------------------------------------------

## [v0.7.0 (2022-01-13)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.6.0..0.7.0)

### Added
* Metrics
* Debug mode, command `mr-linter lint --debug`
* Logging for HTTP Requests

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.7.0)

-----------------------------------------------------------------

## [v0.6.0 (2022-01-11)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.5.1..0.6.0)

### Added
* Added Rule **HasChanges**
* Added ApplicationFactory
* Added InfoCommand `mr-linter info`
* Added conditions `countEquals`, `countNotEquals`

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.6.0)

-----------------------------------------------------------------

## [v0.5.1 (2022-01-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.5.0..0.5.1)

### Fixed
* [Bug] Credentials are required to be filled

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.5.1)

-----------------------------------------------------------------

## [v0.5.0 (2022-01-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.4.0..0.5.0)

### Added
* Added YAML Config Loader

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.5.0)

-----------------------------------------------------------------

## [v0.4.0 (2022-01-07)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.3.0..0.4.0)

### Added
* Added rule conditions

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.4.0)

-----------------------------------------------------------------

## [v0.3.0 (2021-12-11)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.2.0..0.3.0)

### Added
* Loading Config from JSON
* Docker image

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.3.0)

-----------------------------------------------------------------

## [v0.2.0 (2021-12-06)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.5..0.2.0)

### Added
* Added method `getName` to Rule

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.2.0)

-----------------------------------------------------------------

## [v0.1.5 (2021-03-29)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.4..0.1.5)

### Fixed
* Fix finding composer autoload path in binary

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.5)

-----------------------------------------------------------------

## [v0.1.4 (2021-12-27)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.3..0.1.4)

### Added
* Added rule for check count changed files on a limit
* Added property `changedFilesCount` to merge request objects

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.4)

-----------------------------------------------------------------

## [v0.1.3 (2021-12-08)](https://github.com/ArtARTs36/php-merge-request-linter/compare/v0.1.2..0.1.3)

### Changed
* Update exception hierarchy. Parent: MergeRequestLinterException

### Added
* Added `ServerUnexpectedResponseException`

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.3)

-----------------------------------------------------------------

## [v0.1.2 (2021-12-04)](https://github.com/ArtARTs36/php-merge-request-linter/compare/v0.1.1..v0.1.2)

### Added
* [Feature] Added rule "Has link to YouTrack issue"
* [Feature] Added rule "OnTargetBranchRule"
* Added property "sourceBranch" to MergeRequest object
* Added property "targetBranch" to MergeRequest object

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/v0.1.2)

-----------------------------------------------------------------

## [v0.1.1 (2021-12-04)](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.0..v0.1.1)

### Added
* [Feature] Added rule "Has link to Jira task"

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/v0.1.1)

-----------------------------------------------------------------

## [v0.1.0 (2021-12-04)](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.0)

### Added
* 🔥 Init library

[💾 Assets](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.0)
