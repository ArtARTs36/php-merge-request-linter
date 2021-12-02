# Merge Request Linter

This package provides tool for validate merge requests

[Show validation rules](docs/rules.md)

## Installation
* Run: `composer require --dev artarts36/merge-request-linter`
* Run `./vendor/bin/mr-linter install`. In root directory added file `.mr-linter.php`
* Configure `.mr-linter.php`

## Usage

Add into your composer.json new script (section **scripts**):

```json
    "mr-lint": [
        "php ./bin/mr-linter lint"
    ]
```

### ➜ Usage with Gitlab CI

Add new step into **.gitlab-ci.yml**:

```yml
mr-lint:
  stage: lint
  only:
    - merge_requests
  script:
    - composer mr-lint
```

### ➜ Usage with Github Actions

Add new step into **.github/workflows/workflow-name.yml**:

```yml
- name: MR Lint
  run: composer mr-lint
```

## Supported CI Systems

* GitLab CI
* Github Actions
