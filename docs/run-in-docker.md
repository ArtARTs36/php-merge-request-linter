# Run in Docker

This page contains list of commands for Docker.

## Run "lint" command

You need setup variables:
* `MR_ID` - ID of your pull request
* `TOKEN` - GitHub token

```shell
docker run \
  -it \
  -e GITHUB_ACTIONS=1 \
  -e GITHUB_REPOSITORY=artarts36/php-merge-request-linter \
  -e GITHUB_GRAPHQL_URL=https://api.github.com/graphql \
  -e GITHUB_REF_NAME=${MR_ID}/merge \
  -e MR_LINTER_GITHUB_HTTP_TOKEN=${TOKEN} \
  -v "${PWD}/.mr-linter.json:/app/.mr-linter.json:ro" \
  artarts36/merge-request-linter lint
```

## Run "info" command

Run a bash script to show information about **MR Linter**.

```shell
docker run -it artarts36/merge-request-linter info
```

## Run "dump" command

Run a bash script to list the current rules for validating requests.

```shell
docker run -it artarts36/merge-request-linter dump
```

## Run "install" command

Run a bash script to download the configuration.

```shell
docker run -v "${PWD}:/app/:rw" --user 1000:1000 -it artarts36/merge-request-linter install
```
