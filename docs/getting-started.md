# Getting Started

## Config writing

Add config file with name `.mr-linter.yml` or `.mr-linter.json` into your repository.
Examples:
* https://github.com/ArtARTs36/php-merge-request-linter/blob/master/stubs/.mr-linter.yaml
* https://github.com/ArtARTs36/php-merge-request-linter/blob/master/stubs/.mr-linter.json

Or generate **yaml** file with following command:
```shell
docker run -v "${PWD}:/app/:rw" --user 1000:1000 -it artarts36/merge-request-linter:0.10.0 install
```

Or generate **json** file with following command:
```shell
docker run -v "${PWD}:/app/:rw" --user 1000:1000 -it artarts36/merge-request-linter:0.10.0 install --format=json
```

When writing a config, look at [JSON Schema](../mr-linter-config-schema.json).

## Usage with GitHub Actions

[View on Marketplace](https://github.com/marketplace/actions/merge-request-linter)

Implementation example: https://github.com/ArtARTs36/ShellCommand/pull/11

1. Add new workflow file **.github/workflows/review.yml**:
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
          MR_LINTER_GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
```

## Usage with Gitlab CI

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
