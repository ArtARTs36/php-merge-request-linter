# Merge Request Linter

This package provides tool for validate merge requests

[Show validation rules](docs/rules.md)

## Installation
* Run: `composer require --dev artarts36/merge-request-linter`
* Run `./vendor/bin/mr-linter install`. In root directory added file `.mr-linter.php`
* Configure `.mr-linter.php`

You can also download [PHAR](https://github.com/ArtARTs36/php-merge-request-linter/releases)

## Available Commands

| Command  | Description  |
| ------------ | ------------ |
| mr-linter install  | Install this tool  |
| mr-linter dump  | Print current rules  |
| mr-linter lint  | Run lint to current merge request  |

## Usage

Add new script into your composer.json (section **scripts**):

```json
    "mr-lint": [
        "./bin/mr-linter lint"
    ]
```

### ➜ Usage with Gitlab CI

1. Generate token on `https://{gitlab-host}/-/profile/personal_access_tokens`
2. Open `https://{gitlab-host}/group/project/-/settings/ci_cd`. Add new variable "MR_LINTER_GITLAB_HTTP_TOKEN" with your personal access token
3. Add new step into **.gitlab-ci.yml**:
   ```yml
   mr-lint:
     stage: lint
     only:
       - merge_requests
     script:
       - composer mr-lint
   ```

### ➜ Usage with Github Actions

1. Generate token on [page](https://github.com/settings/tokens/new)
2. Open https://github.com/{owner}/{repo}/settings/secrets/actions/new. Add new secret "MR_LINTER_GITHUB_HTTP_TOKEN" with your personal access token
3. Add new step into **.github/workflows/workflow-name.yml**:
    ```yml
    - name: MR Lint
      run: composer mr-lint
    ```

## Supported CI Systems

* GitLab CI
* Github Actions

## Development Commands

| Command  | Description  |
| ------------ | ------------ |
| composer test  | Run tests (via PHPUnit)  |
| composer lint  | Run lint (via PHPCsFixer)  |
| php docs/Builder/build_rules.php | Build rules doc page  |
| ./dev/build/build.sh | Build phar of source |
