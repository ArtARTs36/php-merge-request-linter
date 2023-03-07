# Run in Docker

This page contains list of commands for Docker.

## Run "lint" command

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

## Run "info" command

```shell
docker run \
  -it \
  artarts36/merge-request-linter:${MR_LINTER_VERSION} info
```

## Run "dump" command:

```shell
docker run \
  -it \
  artarts36/merge-request-linter:${MR_LINTER_VERSION} dump
```

## Run "install" command:

```shell
docker run -v "${PWD}:/app/:rw" --user 1000:1000 -it artarts36/merge-request-linter:0.10.0 install
```
