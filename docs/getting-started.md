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

When writing a config, look at [JSON Schema](config-schema.md).

## Usage with GitHub Actions

[View on Marketplace](https://github.com/marketplace/actions/merge-request-linter)

Implementation example: https://github.com/ArtARTs36/ShellCommand/pull/11

Add new workflow file **.github/workflows/review.yml**:
```yml
name: PR Review

on:
   pull_request:
      branches: [ master ]
      types:
         - opened
         - synchronize
         - reopened
         - edited

jobs:
build:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v2

      - name: Lint Pull Request
        uses: mr-linter/mr-linter-ga@v0.2.0
        env:
          MR_LINTER_HTTP_TOKEN: ${{ secrets.GITHUB_TOKEN }}
```

## Usage with Gitlab CI

[See example](https://gitlab.com/artem_ukrainsky/mr-linter-testing/)

1. Generate token on `https://{gitlab-host}/-/profile/personal_access_tokens`
2. Open `https://{gitlab-host}/group/project/-/settings/ci_cd`. Add new variable `MR_LINTER_HTTP_TOKEN` with your personal access token
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

You can also use `$CI_JOB_TOKEN` if you don't intend to use comments.

Configs with `$CI_JOB_TOKEN`:

* mr-linter.yaml:
   ```yaml
   ci:
     gitlab_ci: 
       credentials:
         job_token: 'env(MR_LINTER_GITHUB_HTTP_TOKEN)'
   ```

* gitlab-ci.yaml
   ```yaml
   mr-lint:
     image: artarts36/merge-request-linter:0.16.rc-2
     stage: test
     only:
       - merge_requests
     variables:
       MR_LINTER_GITLAB_HTTP_TOKEN: $CI_JOB_TOKEN
     script:
       - mr-linter lint --debug
   ```

## Usage with Bitbucket Pipelines

1. Create App Password on `https://bitbucket.org/account/settings/app-passwords/new` with permissions: 
   * Account: read
   * Repositories: read
   * Pull requests: read

2. Add new repository variable `MR_LINTER_APP_PASSWORD` on `https://bitbucket.org/{repository-owner}/{repository-name}/admin/addon/admin/pipelines/repository-variables`

3. Add new step into **bitbucket-pipelines.yaml**
   ```yaml
   pipelines:
     pull-requests:
       '**':
         - step:
             image: "artarts36/merge-request-linter:0.11.0"
             name: PR Review
             script:
               - mr-linter lint
   ```

4. Setup credentials in `mr-linter.yaml` as:
   ```yaml
   ci:
     bitbucket_pipelines:
       credentials:
         app_password:
           user: your-login
           password: 'env(MR_LINTER_APP_PASSWORD)'
   ```

### Labels

Currently, Bitbucket does not support labels natively.

But if you need labels, you can simulate them by specifying the labels in the pull request description itself.

To do this, you need to do the following configuration:

```yaml
ci:
  bitbucket_pipelines:
    labels:
      of_description:
        line_starts_with: 'Labels: '
        separator: ', '
    credentials:
      app_password:
        user: 'env(MR_LINTER_BITBUCKET_USER)'
        password: 'env(MR_LINTER_BITBUCKET_PASSWORD)'
```
