# CHANGELOG for Merge Request Linter

This file contains changelogs.

[View all Releases](https://github.com/ArtARTs36/php-merge-request-linter/releases)

## [v0.10.1](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.10.0..0.10.1)

### Added
* Documentation for conditions
* Rule `@mr-linter/title_starts_with_task_number` for checking task number in request title

-----------------------------------------------------------------

## [v0.10.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.9.0..0.10.0)

### Added
* Notifications for telegram on events: **lint_finished**, **lint_started**

-----------------------------------------------------------------

## [v0.9.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.8.1..0.9.0)

### Added
* Added markdown condition operator: `containsHeading`
* Added condition operator: `linesMax`
* Added condition operator: `containsLine`

### Internal
* Refactored condition evaluator resolving
* 🚀 Up test coverage to 40.21%
* Add dependency **psr/clock**

-----------------------------------------------------------------

## [v0.8.1](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.8.0..0.8.1)

### Fixed
* Fixed `NativeJsonDecoder`

### Internal
* Added some tests

-----------------------------------------------------------------

## [v0.8.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.11..0.8.0)

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

-----------------------------------------------------------------

## [v0.7.11](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.10..0.7.11)

### Added
* Added Custom rule for user conditions

-----------------------------------------------------------------

## [v0.7.10](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.9..0.7.10)

### Added
* Added dependency check

### Fixed
* Fixed direct dependencies

-----------------------------------------------------------------

## [v0.7.9](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.8..0.7.9)

### Added
* Added condition `match` for chechking string on match regex.

-----------------------------------------------------------------

## [v0.7.8](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.7..0.7.8)

### Internal
* Added coverage reporting
* Added some tests

-----------------------------------------------------------------

## [v0.7.7](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.6..0.7.7)

### Added
* Added `notStarts` Condition Operator
* Added `notEnds` Condition Operator

-----------------------------------------------------------------

## [v0.7.6](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.5..0.7.6)

### Added
* Added interface `HasDebugInfo` for better object printing.

-----------------------------------------------------------------

## [v0.7.5](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.4..0.7.5)

### Changed
* Moved exception on building guzzle client to ClientFactory
* Static class URI

### Fixed
* Command `dump`: print concrete rule class

-----------------------------------------------------------------

## [v0.7.4](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.3..0.7.4)

### Added
* Added command `mr-linter install`: Copy config into yaml, json files

-----------------------------------------------------------------

## [v0.7.3](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.2..0.7.3)

### Changed
* Configuration loading refactoring

-----------------------------------------------------------------

## [v0.7.2](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.1..0.7.2)

### Added
* Support many configurations for Rule
* Condition Operator 'countEqualsAny'

-----------------------------------------------------------------

## [v0.7.1](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.7.0..0.7.1)

## Internal
* Deptrac
* Contracts for YAML/JSON decoding.

-----------------------------------------------------------------

## [v0.7.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.6.0..0.7.0)

### Added
* Metrics
* Debug mode, command `mr-linter lint --debug`
* Logging for HTTP Requests

-----------------------------------------------------------------

## [v0.6.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.5.1..0.6.0)

### Added
* Added Rule **HasChanges**
* Added ApplicationFactory
* Added InfoCommand `mr-linter info`
* Added conditions `countEquals`, `countNotEquals`

-----------------------------------------------------------------

## [v0.5.1](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.5.0..0.5.1)

### Fixed
* [Bug] Credentials are required to be filled

-----------------------------------------------------------------

## [v0.5.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.4.0..0.5.0)

### Added
* Added YAML Config Loader

-----------------------------------------------------------------

## [v0.4.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.3.0..0.4.0)

### Added
* Added rule conditions

-----------------------------------------------------------------

## [v0.3.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.2.0..0.3.0)

### Added
* Loading Config from JSON
* Docker image

-----------------------------------------------------------------

## [v0.2.0](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.5..0.2.0)

### Added
* Added method `getName` to Rule

-----------------------------------------------------------------

## [v0.1.5](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.4..0.1.5)

### Fixed
* Fix finding composer autoload path in binary

-----------------------------------------------------------------

## [v0.1.4](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.3..0.1.4)

### Added
* Added rule for check count changed files on a limit
* Added property `changedFilesCount` to merge request objects

-----------------------------------------------------------------

## [v0.1.3](https://github.com/ArtARTs36/php-merge-request-linter/compare/v0.1.2..0.1.3)

### Changed
* Update exception hierarchy. Parent: MergeRequestLinterException

### Added
* Added `ServerUnexpectedResponseException`

-----------------------------------------------------------------

## [v0.1.2](https://github.com/ArtARTs36/php-merge-request-linter/compare/v0.1.1..v0.1.2)

### Added
* [Feature] Added rule "Has link to YouTrack issue"
* [Feature] Added rule "OnTargetBranchRule"
* Added property "sourceBranch" to MergeRequest object
* Added property "targetBranch" to MergeRequest object

-----------------------------------------------------------------

## [v0.1.1](https://github.com/ArtARTs36/php-merge-request-linter/compare/0.1.0..v0.1.1)

### Added
* [Feature] Added rule "Has link to Jira task"

-----------------------------------------------------------------

## [v0.1.0](https://github.com/ArtARTs36/php-merge-request-linter/releases/tag/0.1.0)

### Added
* 🔥 Init library
