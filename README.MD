# Merge Request Linter

![Testing](https://github.com/ArtARTs36/php-merge-request-linter/workflows/Testing/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/ArtARTs36/php-merge-request-linter/branch/master/graph/badge.svg?token=OGRWW81OHH)](https://codecov.io/gh/ArtARTs36/php-merge-request-linter)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
![Latest Version](https://img.shields.io/packagist/v/artarts36/merge-request-linter)
![Total Downloads](https://poser.pugx.org/artarts36/merge-request-linter/d/total.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/artarts36/merge-request-linter)

This package provides tools for validating merge requests

[Show validation rules](docs/rules.md)

[Creating custom rule](docs/custom_rule.md)

[Docker Image](https://hub.docker.com/repository/docker/artarts36/merge-request-linter)

## Installation

Add config file with name `.mr-linter.yml` or `.mr-linter.json`.
Examples:
* https://github.com/ArtARTs36/php-merge-request-linter/blob/master/stubs/.mr-linter.yaml
* https://github.com/ArtARTs36/php-merge-request-linter/blob/master/stubs/.mr-linter.json

## ➜ Usage with GitHub Actions

[View on Marketplace](https://github.com/marketplace/actions/merge-request-linter)

Implementation example: https://github.com/ArtARTs36/ShellCommand/pull/11

1. Generate token on [page](https://github.com/settings/tokens/new)
2. Open https://github.com/{owner}/{repo}/settings/secrets/actions/new. Add new secret "MR_LINTER_GITHUB_HTTP_TOKEN" with your personal access token
3. Add new workflow file **.github/workflows/review.yml**:
```yml
name: PR Review

on:
pull_request:
branches: [ master ]

jobs:
build:

    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v2

      - name: Lint Pull Request
        uses: mr-linter/mr-linter-ga@v0.2.0
        env:
          MR_LINTER_GITHUB_TOKEN: ${{ secrets.MR_LINTER_GITHUB_HTTP_TOKEN }}
```

## ➜ Usage with Gitlab CI

[See example](https://gitlab.com/artem_ukrainsky/mr-linter-testing/)

1. Generate token on `https://{gitlab-host}/-/profile/personal_access_tokens`
2. Open `https://{gitlab-host}/group/project/-/settings/ci_cd`. Add new variable "MR_LINTER_GITLAB_HTTP_TOKEN" with your personal access token
3. Add new step into **.gitlab-ci.yml**
   ```yaml
   mr-lint:
     image: artarts36/merge-request-linter:0.8.0
     stage: test
     only:
       - merge_requests
     script:
       - mr-linter lint
   ```

## Run in Docker

Simple bash:
```shell
docker run \
  -it \
  -e GITHUB_ACTIONS=1 \
  -e GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
  -e GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
  -e GITHUB_REF_NAME=${MR_ID}/merge \
  -e MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} \
  -v "${PWD}/.mr-linter.json:/app/.mr-linter.json:ro" \
  artarts36/merge-request-linter:${MR_LINTER_VERSION} lint
```

## Available Commands

| Command                                      | Description                                                   |
|----------------------------------------------|---------------------------------------------------------------|
| ./vendor/bin/mr-linter install               | Install this tool (copy configuration file to work directory) |
| ./vendor/bin/mr-linter install --format=yaml | Install this tool (copy configuration file to work directory) |
| ./vendor/bin/mr-linter dump                  | Print current rules                                           |
| ./vendor/bin/mr-linter lint                  | Run lint to current merge request                             |
| ./vendor/bin/mr-linter info                  | Print info about MR Linter                                    |


## JSON Config

[See JsonSchema](mr-linter-config-schema.json)

```json
{
  "rules": {
    "@mr-linter/changed_files_limit": {
      "limit": 20
    },
    "@mr-linter/jira/has_issue_link": {
      "domain": "jira.com",
      "projectCode": "MYPROJECT", 
      "when": {
         "title": {
            "starts": "WIP-REQUEST"
         }
      }
    },
    "@mr-linter/description_not_empty": {
       "when": {
          "targetBranch": {
             "equals": "master"
          }
       }
    }
  },
  "credentials": {
    "github_actions": "env(MR_LINTER_GITHUB_HTTP_TOKEN)"
  }
}
```

## YAML Config

[See JsonSchema](mr-linter-config-schema.json)

```yaml
rules:
  "@mr-linter/changed_files_limit":
     limit: 20

  "@mr-linter/jira/has_issue_link":
     domain: "jira.com"
     projectCode: "MYPROJECT"
     when:
       title:
         starts: "WIP-REQUEST"

  "@mr-linter/description_not_empty":
    when:
      targetBranch:
        equals: "master"
        
    custom:
       - definition: "Title must include 'BUG'"
         rules:
            title:
               match: "/BUG/i"
         when:
            targetBranch:
               equals: master

credentials:
  github_actions: "env(MR_LINTER_GITHUB_HTTP_TOKEN)"
```

## Development Commands

| Command                  | Description                                          |
|--------------------------|------------------------------------------------------|
| composer test            | Run tests (via PHPUnit)                              |
| composer lint            | Run lint (via PHPCsFixer)                            |
| composer deptrac         | Run deptrac                                          |
| make deps-check          | Check composer requires (via ComposerRequireChecker) |
| make check               | Run test, lint, stat-analyse, deptrac                |
| make docs                | Build docs (rule page, Config JSON Schema)           |
| make env                 | Add .env file                                        |
| make try MR_ID=10        | Run MR-Linter on really pull request                 |
| make try-gitlab MR_ID=10 | Run MR-Linter on really merge request                |

## Console output example

![Example](docs/output_example.png)
