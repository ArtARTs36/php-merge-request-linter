<h1 align="center">MR Linter - merge/pull request validator</h1>

![Testing](https://github.com/ArtARTs36/php-merge-request-linter/workflows/Testing/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/ArtARTs36/php-merge-request-linter/branch/master/graph/badge.svg?token=OGRWW81OHH)](https://codecov.io/gh/ArtARTs36/php-merge-request-linter)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
![Latest Version](https://img.shields.io/packagist/v/artarts36/merge-request-linter)
![Total Downloads](https://poser.pugx.org/artarts36/merge-request-linter/d/total.svg)
![Docker Pulls](https://img.shields.io/docker/pulls/artarts36/merge-request-linter)

This project provides tools for validating merge/pull requests.

Supported CI Systems: **Github Actions**, **Gitlab CI**.

## Documentation

* [Getting Started](docs/getting_started.md)
* [Show validation rules](docs/rules.md)
* [Creating custom rule](docs/custom_rule.md)
* [Docker Image](https://hub.docker.com/repository/docker/artarts36/merge-request-linter)
* [Config JSON Schema](mr-linter-config-schema.json)
* [Development](docs/development.md)

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

## Console output example

![Example](docs/output_example.png)
